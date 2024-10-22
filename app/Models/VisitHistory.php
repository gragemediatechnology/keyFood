<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitHistory extends Model
{
    protected $fillable = ['ip_address', 'user_id', 'visited_at'];
    
    protected $casts = [
        'visited_at' => 'datetime',
    ];
}
