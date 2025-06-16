<?php

namespace Database\Seeders;

use App\Models\StatusReward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusReward::create([
            'status' => 'Menunggu'
        ]);

        StatusReward::create([
            'status' => 'Diproses'
        ]);

        StatusReward::create([
            'status' => 'Selesai'
        ]);


    }
}
