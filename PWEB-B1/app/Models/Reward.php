<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'rewards';
    protected $primaryKey = 'reward_id';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'jumlah_ember_harga',
        'gambar',
    ];

    public function detailRewards()
    {
        return $this->hasMany(DetailReward::class, 'reward_id');
    }
}
