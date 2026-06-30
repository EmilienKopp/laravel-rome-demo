<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ASU extends Model
{
    protected $table = 'active_subscription_usage';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'subscription_id' => 'integer',
        'user_id' => 'integer',
        'total_usage' => 'float',
    ];
}
