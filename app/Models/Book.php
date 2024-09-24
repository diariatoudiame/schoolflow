<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'book_number',
        'published_date',
        'genre',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations');
    }
}
