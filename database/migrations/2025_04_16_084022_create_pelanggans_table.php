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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('pelanggan_id');
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_telepon', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->dateTime('tanggal_berlangganan')->nullable();
            $table->string('status_berlangganan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
