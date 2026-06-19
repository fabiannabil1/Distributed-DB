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
         Schema::create('artikels', function (Blueprint $table) {
            $table->id('artikel_id');
            $table->string('judul');
            $table->text('konten');
            $table->string('gambar');
            $table->timestamp('tanggal_dibuat');
            $table->unsignedBigInteger('admin_id')->constrained('admins')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
