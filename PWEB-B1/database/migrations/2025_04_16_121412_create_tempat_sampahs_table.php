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
        Schema::create('tempat_sampahs', function (Blueprint $table) {
            $table->id('tempat_sampah_id');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->string('status_penuh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_sampahs');
    }
};
