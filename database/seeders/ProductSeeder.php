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
                "kategori" => "Fashion",
                "stok" => 3000,
                "terjual" => 12000,
                "bahan" => "Katun Combed 24s, Polyester, Dry Fit",
                "warna" => "Merah, Biru, Hitam, Putih"
            ],
            [
                "nama" => "Cetak Banner Spanduk Custom",
                "harga" => 45000,
                "file" => "assets/etalase_produk/banner.jpeg",
                "rating" => 4.6,
                "kategori" => "Percetakan",
                "stok" => 3500,
                "terjual" => 10000,
                "bahan" => "Flexi China, Flexi Jerman, Vinyl, PVC",
                "warna" => "Merah, Biru, Hitam, Putih"
            ],
            [
                "nama" => "Furniture Store Brosur Bifold",
                "harga" => 55000,
                "file" => "assets/etalase_produk/Furniture Store Bifold Brochure Template PSD, INDD.jpeg",
                "rating" => 4.7,
                "kategori" => "Desain Grafis",
                "stok" => 5000,
                "terjual" => 19200,
                "bahan" => "Art Paper, Ivory, HVS, Matt Paper",
                "warna" => "Full Color, No Color"
            ],
            [
                "nama" => "Notebook For Writers And Journalers",
                "harga" => 75000,
                "file" => "assets/etalase_produk/notebook.jpeg",
                "rating" => 4.9,
                "kategori" => "Alat Tulis",
                "stok" => 1500,
                "terjual" => 12000,
                "bahan" => "Kertas HVS, Kertas Doff, Kertas Art Paper",
                "warna" => "Merah, Biru, Hitam, Putih"
            ],
            [
                "nama" => "Poster Design",
                "harga" => 95000,
                "file" => "assets/etalase_produk/poster.jpeg",
                "rating" => 4.8,
                "kategori" => "Desain Grafis",
                "stok" => 10000,
                "terjual" => 12000,
                "bahan" => "Kertas HVS, Kertas Doff, Kertas Art Paper",
                "warna" => "Merah, Biru, Hitam, Putih"
            ],
            [
                "nama" => "Totebag Eco-friendly Gift Packaging",
                "harga" => 68000,
                "file" => "assets/etalase_produk/totebag.jpeg",
                "rating" => 4.7,
                "kategori" => "Fashion",
                "stok" => 8000,
                "terjual" => 2000,
                "bahan" => "Kanvas, Blacu, D300, D600",
                "warna" => "Coklat, Hitam, Putih"
            ],
            [
                "nama" => "Custom Majalah",
                "harga" => 78000,
                "file" => "assets/etalase_produk/majalah.jpeg",
                "rating" => 4.6,
                "kategori" => "Percetakan",
                "stok" => 90000,
                "terjual" => 12000,
                "bahan" => "Kertas HVS, Kertas Doff, Kertas Art Paper",
                "warna" => "Merah, Biru, Hitam, Putih"
            ],
            [
                "nama" => "Custom Pin Design",
                "harga" => 99000,
                "file" => "assets/etalase_produk/Shop — Drawn by Nana.jpeg",
                "rating" => 4.9,
                "kategori" => "Merchandise",
                "stok" => 3200,
                "terjual" => 12500,
                "bahan" => "Acrylic, Enamel, Metal",
                "warna" => "Emas, Perak, Tembaga"
            ],
            [
                "nama" => "Custom Kalender Meja",
                "harga" => 52000,
                "file" => "assets/etalase_produk/6c86d7a5-f9ee-4e8f-91aa-4489dd5ffc11.jpeg",
                "rating" => 3,
                "kategori" => "Percetakan",
                "stok" => 29000,
                "terjual" => 19000,
                "bahan" => "Kertas HVS, Kertas Doff, Kertas Art Paper",
                "warna" => "Merah, Biru, Hitam, Putih"
            ],
            [
                "nama" => "Custom X Banner",
                "harga" => 60000,
                "file" => "assets/etalase_produk/x-banner.jpeg",
                "rating" => 4.8,
                "kategori" => "Percetakan",
                "stok" => 16000,
                "terjual" => 7000,
                "bahan" => "Flexi China, Flexi Jerman, Vinyl, PVC",
                "warna" => "Merah, Biru, Hitam, Putih"
            ]
        ];


        foreach ($data as $item) {
            Product::create($item);
        }
    }
}