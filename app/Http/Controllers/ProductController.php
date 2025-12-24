<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
class ProductController extends Controller
{
    private $apiURL = 'https:/localhost:3000/v1/api/products';

    public function index()
    {
        $response = Http::get($this->apiURL);
        $products = $response->json()['data'] ?? [];

        return view('product-page', compact('products'));
    }

    public function show($id)
    {
        $response = Http::get($this->apiURL);

        $product = $response->json()['data'][$id - 1] ?? null;

        if(!$product) {
            abort(404);
        }
        return view('product-detail', compact('products'));
    }
}