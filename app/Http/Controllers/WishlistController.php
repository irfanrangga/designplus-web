<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Fungsi untuk Toggle (Add/Remove via AJAX)
    public function toggle(Request $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        // Cek apakah sudah ada di wishlist
        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            // Jika ada, hapus 
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Produk dihapus dari Wishlist.']);
        } else {
            // Jika tidak ada, tambah 
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return response()->json(['status' => 'added', 'message' => 'Produk ditambahkan ke Wishlist.']);
        }
    }
}