<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteMessage extends Model
{
    // Fillable
    protected $fillable = [
        'name',
        'subject',
        'email',
        'phone',
        'message',
        'status',
    ];
}
