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
        Schema::create('detail_pengambilan_sampahs', function (Blueprint $table) {
            $table->id('detail_pengambilan_id');
            $table->unsignedBigInteger('pengambilan_id');
            $table->date('tanggal_pengambilan');
            $table->unsignedBigInteger('admin_id');

            // Foreign keys
            $table->foreign('pengambilan_id')->references('pengambilan_id')->on('pengambilan_sampahs')->onDelete('cascade');
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengambilan_sampahs');
    }
};
