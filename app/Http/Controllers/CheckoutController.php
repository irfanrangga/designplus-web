<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Memproses Checkout (Pindah Data Cart -> Order)
     */
    public function process(Request $request)
    {
        $user = Auth::user();
        // Support dua mode checkout:
        // - Dari keranjang: tanpa product_id -> ambil item yang is_selected di cart
        // - Direct purchase: ada product_id dari product-detail form

        $cartItems = collect();

        if ($request->filled('product_id')) {
            // Direct purchase dari halaman produk
            $productId = $request->input('product_id');
            $quantity = max(1, (int) $request->input('quantity', 1));
            $material = $request->input('material');
            $warna = $request->input('warna');
            $designType = $request->input('design_type', 'standard');

            $product = \App\Models\Product::find($productId);
            if (! $product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            // handle uploaded file if custom design
            $customFilePath = null;
            if ($designType === 'custom' && $request->hasFile('custom_file')) {
                $file = $request->file('custom_file');
                $customFilePath = $file->store('uploads/custom_designs', 'public');
            }

            // Buat pseudo-cart item untuk diproses bersama format yang sama
            $cartItems->push((object) [
                'product' => $product,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'material' => $material,
                'warna' => $warna,
                'design_type' => $designType,
                'custom_file' => $customFilePath,
            ]);
        } else {
            // Checkout dari cart (biasa)
            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->where('is_selected', true)
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada barang yang dipilih untuk dicheckout.');
            }
        }

        // 2. Hitung Total Bayar
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item->product->harga;
            $qty = $item->quantity;
            $subtotal += ($price * $qty);
        }

        // Tambah pajak/diskon jika ada (sesuaikan logika bisnis Anda)
        $tax = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        // 3. Mulai Database Transaction (Penting! Agar data konsisten)
        // Jika ada error di tengah jalan, semua perubahan dibatalkan (Rollback)
        DB::beginTransaction();

        try {
            // A. Buat Header Order
            $order = Order::create([
                'user_id'        => $user->id,
                'number'         => 'INV-' . date('YmdHis') . '-' . $user->id, // Contoh No Invoice
                'total_price'    => $grandTotal,
                'payment_status' => '1', // 1 = Unpaid (sesuai enum Anda)
                'order_status'   => 'pending',
            ]);

            // B. Pindahkan setiap item Cart ke OrderItem
            foreach ($cartItems as $cart) {
                // normalize values
                $productId = $cart->product_id ?? $cart->product->id;
                $product = $cart->product;
                $quantity = $cart->quantity;
                $bahan = $cart->material ?? null;
                $warna = $cart->warna ?? null;
                $customFile = $cart->custom_file ?? null;

                // Build note: include design_type if provided
                $noteParts = [];
                if (! empty($cart->design_type)) {
                    $noteParts[] = 'Desain: ' . $cart->design_type;
                }
                if (! empty($cart->note)) {
                    $noteParts[] = $cart->note;
                }
                $note = count($noteParts) ? implode("\n", $noteParts) : null;

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $productId,
                    'product_name'  => $product->nama,  // Snapshot Nama
                    'product_price' => $product->harga, // Snapshot Harga
                    'bahan'         => $bahan,
                    'warna'         => $warna,
                    'quantity'      => $quantity,
                    'custom_file'   => $customFile,
                    'note'          => $note,
                    'subtotal'      => $product->harga * $quantity,
                ]);
            }

            // C. Hapus item di keranjang yang sudah dipesan
            // Jika checkout dari cart, hapus item yang dipesan
            if (! $request->filled('product_id')) {
                Cart::where('user_id', $user->id)
                    ->where('is_selected', true)
                    ->delete();
            }

            // D. Commit Transaksi (Simpan Permanen)
            DB::commit();

            // E. Redirect ke halaman sukses / pembayaran
            // return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');
            return redirect()->route('cart')->with('success', 'Checkout Berhasil! Pesanan telah dibuat.');

        } catch (\Exception $e) {
            // Jika ada error, batalkan semua perubahan database
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout: ' . $e->getMessage());
        }
    }
}