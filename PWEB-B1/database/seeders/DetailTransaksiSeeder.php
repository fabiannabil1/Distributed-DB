<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggan = Pelanggan::first();
        $produkList = Produk::all()->take(3); // ambil 3 produk

        foreach ($produkList as $produk) {
            DetailTransaksi::create([
                'produk_id' => $produk->id,
                'pelanggan_id' => $pelanggan->pelanggan_id,
                'qty' => rand(1, 3),
                'harga' => $produk->harga,
                'isDraft' => true,
                'transaksi_id' => null,
            ]);
        }
    }
}
