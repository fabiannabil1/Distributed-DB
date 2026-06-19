<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTransaksi extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'status',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
