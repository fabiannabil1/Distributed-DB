<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berlangganan extends Model
{
    protected $table = 'berlangganans';
    protected $primaryKey = 'berlangganan_id';
    public $timestamps = true;

    protected $fillable = [
        'pelanggan_id',
        'biaya_berlangganan',
        'midtrans_order_id'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
