<?php

namespace Database\Seeders;

use App\Models\StatusTransaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'gagal',
            'menunggu pembayaran',
            'diproses',
            'dikirim',
            'selesai',
        ];

        foreach ($statuses as $status) {
            StatusTransaksi::create([
                'status' => $status
            ]);
        }
    }
}
