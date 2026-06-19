<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusReward extends Model
{
    protected $table = 'status_rewards';
    protected $primaryKey = 'status_reward_id';
    public $timestamps = false;

    protected $fillable = ['nama_status'];

    public function detailRewards()
    {
        return $this->hasMany(DetailReward::class, 'status_reward_id');
    }
}
