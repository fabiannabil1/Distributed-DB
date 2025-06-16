<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap', 'email', 'password', 'nomor_telepon',
    ];

    protected $hidden = ['password'];
}
