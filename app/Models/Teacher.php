<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'date_of_birth',
        'qualification',
        'experience',
        'phone_number',
        'address',

    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
