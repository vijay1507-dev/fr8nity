<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'points',
        'description',
    ];
    
}
