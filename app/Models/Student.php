<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'roll',
        'blood_group',

        'phone_number',
        'upload',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'class_student', 'student_id', 'class_id')
            ->withPivot('academic_year'); // Inclure l'année académique dans la relation
    }

//    public function classes()
//    {
//        return $this->belongsToMany(Classe::class);
//    }
}
