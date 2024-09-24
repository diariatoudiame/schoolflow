<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Reservation extends Pivot
{
    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'book_id',
        'reservation_date',
        'duration', // Durée de réservation
    ];

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le modèle Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
