<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;
    // Fillable
    protected $fillable = [
        'book_id',
        'date',
        'no',
        'title',
        'duration',
        'audio',
    ];

    // Book relationship
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
