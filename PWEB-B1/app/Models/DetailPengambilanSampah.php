<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengambilanSampah extends Model
{
    protected $table = 'detail_pengambilan_sampahs';
    protected $primaryKey = 'detail_pengambilan_id';
    public $timestamps = false;
    protected $fillable = ['pengambilan_id', 'tanggal_pengambilan', 'admin_id'];

    public function pengambilan()
    {
        return $this->belongsTo(PengambilanSampah::class, 'pengambilan_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
