<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $orderData = [
            'product' => [
                'name' => 'Kaos Polos + Sablon',
                'image' => 'assets/img_detail_1.png',
                'price' => 17500
            ],
            'material' => [
                'name' => 'Cotton Combed 30s',
                'price' => 5000
            ],
            'color' => [
                'name' => 'White',
                'hex' => '#FFFFFF',
                'price' => 0
            ],
            'design' => [
                'name' => 'Custom A4',
                'price' => 5000
            ],
            'quantity' => 100,
            'shipping_cost' => 12500,
            'ppn_percentage' => 0.12,
        ];

        $pricePerItem = $orderData['product']['price'] + 
                        $orderData['material']['price'] + 
                        $orderData['color']['price'] + 
                        $orderData['design']['price'];
        
        $itemSubtotal = $pricePerItem * $orderData['quantity'];
        $discount = 10000; 
        $ppn = $itemSubtotal * $orderData['ppn_percentage'];
        $grandTotal = $itemSubtotal + $orderData['shipping_cost'] - $discount + $ppn;

        $addresses = [
            'Kantor - Muhammad Fulan (Jl. Moch Yamin No.26, Bojongsoang, Kabupaten Bandung, Jawa Barat, 18721)',
            'Rumah - Muhammad Fulan (Jl. Dago Atas No. 10, Bandung, Jawa Barat, 40135)',
        ];

        $coupons = [
            ['code' => 'HEMAT10', 'label' => 'Potongan Rp10.000', 'value' => 10000],
            ['code' => 'ONGKIRFREE', 'label' => 'Gratis Ongkir', 'value' => 12500],
        ];

        return view('payment', compact('orderData', 'itemSubtotal', 'discount', 'ppn', 'grandTotal', 'addresses', 'coupons'));
    }
}