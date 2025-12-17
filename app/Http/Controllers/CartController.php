<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $subtotal = 0;

        foreach ($cartItems as $item) {
            if ($item->product) {
                $subtotal += $item->product->harga * $item->quantity;
            }
        }

        $tax = $subtotal * 0.11;
        $discount = 0;
        $total = $subtotal + $tax - $discount;

        return view('cart', compact('cartItems', 'subtotal', 'tax', 'total', 'discount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $qty = $request->quantity ?? 1;

        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity', $qty);
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $qty,
                'is_selected' => true
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        if ($request->ajax() || $request->wantsJson()) {
            $itemTotal = $cartItem->product->harga * $cartItem->quantity;

            return response()->json([
                'success' => true,
                'item_total' => $itemTotal
            ]);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }
}