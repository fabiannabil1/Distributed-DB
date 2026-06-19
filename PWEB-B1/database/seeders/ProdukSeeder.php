<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkList = [
            [
                'nama_produk'=> 'Pupuk Organik A',
                'deskripsi'=> 'Pupuk organik ramah lingkungan untuk tanaman Anda.',
                'harga'=> 50000,
                'gambar'=>' pupuk-organik-a.jpg',
                'stok'=>100,
                'isActive'=>1,
            ],
            [
                'nama_produk'=> 'Pupuk Organik B',
                'deskripsi'=> 'Nutrisi terbaik untuk pertumbuhan tanaman.',
                'harga'=> 50000,
                'gambar'=>' pupuk-organik-b.jpg',
                'stok'=>100,
                'isActive'=>1,
            ],
            [
                'nama_produk'=> 'Pupuk Organik C',
                'deskripsi'=> 'Membantu meningkatkan hasil panen secara alami.',
                'harga'=> 50000,
                'gambar'=>' pupuk-organik-c.jpg',
                'stok'=>100,
                'isActive'=>1,
            ],
            [
                'nama_produk'=> 'Pupuk Organik D',
                'deskripsi'=> 'Pupuk organik ramah lingkungan untuk tanaman Anda.',
                'harga'=> 50000,
                'gambar'=>' pupuk-organik-d.jpg',
                'stok'=>100,
                'isActive'=>0,
            ],
        ];

        foreach ($produkList as $produk) {
            Produk::create($produk);
        }
    }
}
