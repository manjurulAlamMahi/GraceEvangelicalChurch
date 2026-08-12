<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    // Fillable
    protected $fillable = [
        'title',
        'description',
        'image',
    ];
}
