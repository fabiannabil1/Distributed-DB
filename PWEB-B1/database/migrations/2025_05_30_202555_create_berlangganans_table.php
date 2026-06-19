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
        Schema::create('berlangganans', function (Blueprint $table) {
            $table->id('berlangganan_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->integer('biaya_berlangganan');
            $table->string('midtrans_order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berlangganans');
    }
};
