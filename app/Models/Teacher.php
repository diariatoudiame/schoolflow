<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'full_name',
        'gender',
        'date_of_birth',
        'mobile',
        'joining_date',
        'qualification',
        'experience',
        'username',
        'address',

    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
