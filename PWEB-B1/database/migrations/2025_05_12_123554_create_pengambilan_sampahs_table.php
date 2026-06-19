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
        Schema::create('pengambilan_sampahs', function (Blueprint $table) {
            $table->id('pengambilan_id');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->integer('jumlah_ember')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengambilan_sampahs');
    }
};
