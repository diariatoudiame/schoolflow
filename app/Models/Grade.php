<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // Les attributs qui peuvent être remplis en masse
    protected $fillable = [
        'student_id',
        'subject_id',
        'type', // Par exemple : 'devoir', 'examen', etc.
        'grade', // Note
        'comment', // Commentaire
        'evaluation_type'
    ];

    // Définition de la relation avec le modèle Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Définition de la relation avec le modèle Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
