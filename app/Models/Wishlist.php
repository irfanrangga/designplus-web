<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // relasi ke produk untuk mengambil nama, harga, gambar
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}