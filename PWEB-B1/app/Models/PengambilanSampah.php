<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanSampah extends Model
{
    protected $table = 'pengambilan_sampahs';
    protected $primaryKey = 'pengambilan_id';
    public $timestamps = false;

    protected $fillable = ['jumlah_ember', 'pelanggan_id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function detailPengambilan()
    {
        return $this->hasOne(DetailPengambilanSampah::class, 'pengambilan_id');
    }
}
