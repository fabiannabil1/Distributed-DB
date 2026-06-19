<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReward extends Model
{
    protected $table = 'detail_rewards';
    protected $primaryKey = 'detail_reward_id';
    public $timestamps = false;

    protected $fillable = [
        'pelanggan_id',
        'reward_id',
        'status_reward_id',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }

    public function statusReward()
    {
        return $this->belongsTo(StatusReward::class, 'status_reward_id');
    }
}
