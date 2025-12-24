<?php

namespace App\Http\Controllers;

use App\Helpers\ApiClient;
use Illuminate\Http\Request;
use App\Models\Product; 
class ProductController extends Controller
{
    public function index()
    {
        $products = ApiClient::get('/products')->json('data');
        return view('product-page', compact('products'));
    }

    public function show($id)
    {
        $response = ApiClient::get('/products/' . $id);
        if ($response->failed()) {
            abort(404, 'Gagal mengambil produk');
        }

        $product = $response->json('data');

        if(!$product){
            abort(404, 'Produk tidak ditemukan');
        }

        if (isset($product[0])) {
            $product = $product[0];
        }

        return view('product-detail', compact('product'));
    }
}