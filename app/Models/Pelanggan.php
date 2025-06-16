<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap', 'email', 'password', 'nomor_telepon',
        'alamat', 'latitude', 'longitude', 'tanggal_berlangganan', 'status_berlangganan',
    ];

    protected $hidden = ['password'];

    public function tempatSampah()
    {
        return $this->hasOne(TempatSampah::class, 'pelanggan_id');
    }

    public function pengambilanSampah()
    {
        return $this->hasOne(PengambilanSampah::class, 'pelanggan_id');
    }

    public function detailRewards()
    {
        return $this->hasMany(DetailReward::class, 'pelanggan_id');
    }

    public function berlangganan()
    {
        return $this->hasMany(Berlangganan::class, 'pelanggan_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }
}
