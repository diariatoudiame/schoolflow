<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name', // Nom de la classe
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student')
            ->withPivot('academic_year'); // Inclure l'année académique dans la relation

    }
}
