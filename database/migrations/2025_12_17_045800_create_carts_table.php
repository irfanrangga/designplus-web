<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // Menghubungkan cart dengan user (pembeli)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Menghubungkan cart dengan produk yang dibeli
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Jumlah barang
            $table->integer('quantity')->default(1);
            
            // Status checkbox (untuk fitur pilih item di keranjang)
            $table->boolean('is_selected')->default(true); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};