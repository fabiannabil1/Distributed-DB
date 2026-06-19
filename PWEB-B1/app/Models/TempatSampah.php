<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatSampah extends Model
{
    protected $table = 'tempat_sampahs';
    protected $primaryKey = 'tempat_sampah_id';
    public $timestamps = false;

    protected $fillable = ['status_penuh', 'pelanggan_id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
