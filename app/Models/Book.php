<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    // Fillable
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'description',
        'status',
        'author',
    ];

    // Relation
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
