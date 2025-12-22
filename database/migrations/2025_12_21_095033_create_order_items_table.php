<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products'); // Jangan cascade delete agar history aman

            // Kita simpan nama & harga sebagai 'snapshot'. 
            // Jika admin mengubah harga produk bulan depan, data transaksi lama tidak ikut berubah.
            $table->string('product_name');
            $table->decimal('product_price', 12, 2);

            // Menyimpan opsi bahan yang dipilih dari radio button sebelumnya
            $table->string('bahan');
            $table->string('warna');
            $table->integer('quantity');
            $table->decimal('subtotal', 12, 2);

            // Khusus Percetakan: User upload file desain mereka sendiri
            $table->string('custom_file')->nullable();
            $table->text('note')->nullable(); // Catatan finishing, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
