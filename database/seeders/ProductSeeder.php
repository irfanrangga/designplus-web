<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "nama" => "Kaos Tim Knockout 2023",
                "harga" => 120000,
                "file" => "assets/etalase_produk/jersey.jpeg",
                "rating" => 4.8,
                "kategori" => "Fashion"
            ],
            [
                "nama" => "Cetak Banner Spanduk Custom",
                "harga" => 45000,
                "file" => "assets/etalase_produk/banner.jpeg",
                "rating" => 4.6,
                "kategori" => "Percetakan"
            ],
            [
                "nama" => "Furniture Store Brosur Bifold",
                "harga" => 55000,
                "file" => "assets/etalase_produk/Furniture Store Bifold Brochure Template PSD, INDD.jpeg",
                "rating" => 4.7,
                "kategori" => "Desain Grafis"
            ],
            [
                "nama" => "Notebook For Writers And Journalers",
                "harga" => 75000,
                "file" => "assets/etalase_produk/notebook.jpeg",
                "rating" => 4.9,
                "kategori" => "Alat Tulis"
            ],
            [
                "nama" => "Poster Design",
                "harga" => 95000,
                "file" => "assets/etalase_produk/poster.jpeg",
                "rating" => 4.8,
                "kategori" => "Desain Grafis"
            ],
            [
                "nama" => "Totebag Eco-friendly Gift Packaging",
                "harga" => 68000,
                "file" => "assets/etalase_produk/totebag.jpeg",
                "rating" => 4.7,
                "kategori" => "Fashion"
            ],
            [
                "nama" => "Custom Majalah",
                "harga" => 78000,
                "file" => "assets/etalase_produk/majalah.jpeg",
                "rating" => 4.6,
                "kategori" => "Percetakan"
            ],
            [
                "nama" => "Custom Pin Design",
                "harga" => 99000,
                "file" => "assets/etalase_produk/Shop — Drawn by Nana.jpeg",
                "rating" => 4.9,
                "kategori" => "Merchandise"
            ],
            [
                "nama" => "Custom Kalender Meja",
                "harga" => 52000,
                "file" => "assets/etalase_produk/6c86d7a5-f9ee-4e8f-91aa-4489dd5ffc11.jpeg",
                "rating" => 3,
                "kategori" => "Percetakan"
            ],
            [
                "nama" => "Custom X Banner",
                "harga" => 60000,
                "file" => "assets/etalase_produk/x-banner.jpeg",
                "rating" => 4.8,
                "kategori" => "Percetakan"
            ]
        ];


        foreach ($data as $item) {
            Product::create($item);
        }
    }
}