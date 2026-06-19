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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('total');
            $table->string('midtrans_order_id');
            $table->string('catatan')->nullable();
            $table->foreignId('pelanggan_id')->constrained('pelanggans', 'pelanggan_id')->onDelete('cascade');
            $table->foreignId('status_transaksi_id')->constrained('status_transaksis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
