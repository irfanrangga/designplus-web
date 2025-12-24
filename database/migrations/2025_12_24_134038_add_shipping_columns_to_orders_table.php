<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan 2 kolom baru setelah kolom total_price
            $table->string('shipping_address')->nullable()->after('total_price');
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('shipping_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['shipping_address', 'shipping_cost']);
        });
    }
};