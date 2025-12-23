<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Set Xendit Key dari .env
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    }

    /**
     * Memproses Checkout (Pindah Data Cart -> Order & Create Xendit Invoice)
     */
    public function process(Request $request)
    {
        $user = Auth::user();
        $cartItems = collect();

        // 1. Logika Pengambilan Item (Sama seperti sebelumnya)
        if ($request->filled('product_id')) {
            $productId = $request->input('product_id');
            $quantity = max(1, (int) $request->input('quantity', 1));
            $material = $request->input('material');
            $warna = $request->input('warna');
            $designType = $request->input('design_type', 'standard');

            $product = \App\Models\Product::find($productId);
            if (! $product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            $customFilePath = null;
            if ($designType === 'custom' && $request->hasFile('custom_file')) {
                $file = $request->file('custom_file');
                $customFilePath = $file->store('uploads/custom_designs', 'public');
            }

            $cartItems->push((object) [
                'product' => $product,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'material' => $material,
                'warna' => $warna,
                'design_type' => $designType,
                'custom_file' => $customFilePath,
                'note' => $request->input('note') // Tambahkan ini agar note terbawa
            ]);
        } else {
            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->where('is_selected', true)
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada barang yang dipilih untuk dicheckout.');
            }
        }

        // 2. Hitung Total
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += ($item->product->harga * $item->quantity);
        }
        $tax = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        DB::beginTransaction();

        try {
            // A. Buat Order Lokal
            $orderNumber = 'INV-' . date('YmdHis') . '-' . $user->id;
            
            $order = Order::create([
                'user_id'        => $user->id,
                'number'         => $orderNumber,
                'total_price'    => $grandTotal,
                'payment_status' => '1', // Unpaid
                'order_status'   => 'pending',
            ]);

            // B. Simpan Item
            foreach ($cartItems as $cart) {
                // ... (Logika mapping item sama seperti kode Anda sebelumnya)
                $productId = $cart->product_id ?? $cart->product->id;
                $product = $cart->product;
                $noteParts = [];
                if (!empty($cart->design_type)) $noteParts[] = 'Desain: ' . $cart->design_type;
                if (!empty($cart->note)) $noteParts[] = $cart->note;
                $note = count($noteParts) ? implode("\n", $noteParts) : null;

                // 1. Ambil data
                $customFile = $cart->custom_file ?? null;

                // [TAMBAHAN BARU] Cek apakah user sebenarnya memilih Standard?
                // Jika design_type standard, paksa custom_file jadi NULL
                if (isset($cart->design_type) && strtolower($cart->design_type) == 'standard') {
                    $customFile = null;
                }
                // Atau jika file kosong/string kosong
                if (empty($customFile)) {
                    $customFile = null;
                }

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $productId,
                    'product_name'  => $product->nama,
                    'product_price' => $product->harga,
                    'bahan'         => $cart->material ?? $cart->bahan ?? null,
                    'warna'         => $cart->warna ?? null,
                    'quantity'      => $cart->quantity,
                    'custom_file'   => $cart->custom_file ?? null,
                    'note'          => $note,
                    'subtotal'      => $product->harga * $cart->quantity,
                ]);
            }

            // C. Create Xendit Invoice
            $apiInstance = new InvoiceApi();
            $create_invoice_request = new \Xendit\Invoice\CreateInvoiceRequest([
                'external_id' => $orderNumber,
                'amount' => $grandTotal,
                'payer_email' => $user->email,
                'description' => 'Pembayaran Order ' . $orderNumber,
                'invoice_duration' => 43200, // 12 jam
                'success_redirect_url' => route('home'), // <-- Redirect ke Home setelah sukses
                'failure_redirect_url' => route('payment.show', $order->id),
                'currency' => 'IDR'
            ]);

            // Panggil API Xendit
            $invoice = $apiInstance->createInvoice($create_invoice_request);

            // Simpan Link Pembayaran Xendit ke kolom 'snap_token'
            $order->update([
                'snap_token' => $invoice['invoice_url']
            ]);

            // D. Hapus Cart jika bukan direct purchase
            if (! $request->filled('product_id')) {
                Cart::where('user_id', $user->id)->where('is_selected', true)->delete();
            }

            DB::commit();

            // Redirect ke halaman Pembayaran (Show)
            return redirect()->route('payment.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error untuk debugging
            \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Halaman Pembayaran / Detail Order
     */
    public function show($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        
        return view('payment', compact('order'));
    }
}