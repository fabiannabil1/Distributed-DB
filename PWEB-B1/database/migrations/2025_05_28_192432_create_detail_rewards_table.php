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
        Schema::create('detail_rewards', function (Blueprint $table) {
            $table->id('detail_reward_id');
            $table->unsignedBigInteger('pelanggan_id')->nullable();
            $table->unsignedBigInteger('reward_id')->nullable();
            $table->unsignedBigInteger('status_reward_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_rewards');
    }
};
