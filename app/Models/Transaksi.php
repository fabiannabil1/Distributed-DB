<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'midtrans_order_id',
        'pelanggan_id',
        'status_transaksi_id',
        'catatan'
    ];

    protected $casts = [
        'total' => 'integer',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusTransaksi::class, 'status_transaksi_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
