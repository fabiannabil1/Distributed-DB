<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'gambar',
        'stok',
        'isActive'
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
        'isActive'=> 'integer',
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
