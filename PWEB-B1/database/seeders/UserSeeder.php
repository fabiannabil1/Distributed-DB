<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Artikel;
use App\Models\DetailPengambilanSampah;
use App\Models\Pelanggan;
use App\Models\PengambilanSampah;
use App\Models\TempatSampah;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama_lengkap' => 'Admin',
            'email' => 'admin@komposin.com',
            'password' => Hash::make('password'),
            'nomor_telepon' => '081234567890',
        ]);

        Pelanggan::create([
            'nama_lengkap' => 'Ivan',
            'email' => 'ivan@example.com',
            'password' => Hash::make('password'),
            'nomor_telepon' => '081345678901',
            'alamat' => 'Semboro',
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'tanggal_berlangganan' => now(),
            'status_berlangganan' => 'Tidak Aktif',
        ]);

        Pelanggan::create([
            'nama_lengkap' => 'Najwa',
            'email' => 'najwa@example.com',
            'password' => Hash::make('password'),
            'nomor_telepon' => '082230474146',
            'alamat' => 'Sumbersari',
            'latitude' => -8.170662,
            'longitude' => 113.7275817,
            'tanggal_berlangganan' => now(),
            'status_berlangganan' => 'Aktif',
        ]);

        PengambilanSampah::create([
            'pelanggan_id' => 1,
            'jumlah_ember' => 8,
        ]);

        PengambilanSampah::create([
            'pelanggan_id' => 4,
            'jumlah_ember' => 6,
        ]);

        PengambilanSampah::create([
            'pelanggan_id' => 2,
            'jumlah_ember' => 12,
        ]);

        PengambilanSampah::create([
            'pelanggan_id' => 6,
            'jumlah_ember' => 3,
        ]);

        DetailPengambilanSampah::create([
            'pengambilan_id' => 1,
            'tanggal_pengambilan' => now()->subDays(3),
            'admin_id' => 1,
        ]);

        DetailPengambilanSampah::create([
            'pengambilan_id' => 2,
            'tanggal_pengambilan' => now()->subDays(2),
            'admin_id' => 1,
        ]);

        DetailPengambilanSampah::create([
            'pengambilan_id' => 3,
            'tanggal_pengambilan' => now()->subDay(),
            'admin_id' => 1,
        ]);

        TempatSampah::create([
            'pelanggan_id' => 2,
            'status_penuh' => 'hampir penuh',
        ]);

        TempatSampah::create([
            'pelanggan_id' => 4,
            'status_penuh' => 'penuh',
        ]);

        TempatSampah::create([
            'pelanggan_id' => 5,
            'status_penuh' => 'penuh',
        ]);

        TempatSampah::create([
            'pelanggan_id' => 6,
            'status_penuh' => 'kosong',
        ]);

        Artikel::create([
            'judul' => 'Manfaat Kompos untuk Lingkungan',
            'konten' => 'Kompos membantu mengurangi limbah organik dan memperbaiki struktur tanah.',
            'gambar' => 'kompos1.jpg',
            'tanggal_dibuat' => Carbon::now(),
            'admin_id' => 1
        ]);

        Artikel::create([
            'judul' => 'Cara Membuat Kompos di Rumah',
            'konten' => 'Langkah-langkah membuat kompos dari sampah dapur menggunakan ember tertutup.',
            'gambar' => 'kompos2.jpg',
            'tanggal_dibuat' => Carbon::now(),
            'admin_id' => 1
        ]);


    }
}
