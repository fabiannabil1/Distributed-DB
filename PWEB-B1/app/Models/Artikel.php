<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikels';
    protected $primaryKey = 'artikel_id';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'konten',
        'gambar',
        'tanggal_dibuat',
        'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
