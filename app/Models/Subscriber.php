<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    // Fillable
    protected $fillable = [
        'email',
        'created_at',
    ];

    // Cast
    protected $casts = [
        'email' => 'string',
        'created_at' => 'datetime',
    ];
}
