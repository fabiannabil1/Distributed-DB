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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->constrained('pelanggans', 'pelanggan_id')->onDelete('cascade');            $table->integer('qty');
            $table->integer('harga');
            $table->boolean('isDraft')->default(true);
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
