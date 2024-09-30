<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Afficher la liste des emplois du temps
    public function index()
    {
        // Obtenir l'utilisateur connecté
        $user = auth()->user();

        // Initialisation de la variable $classes
        $classes = null;
        $schedules = collect(); // Initialiser la collection vide

        // Vérifier le rôle de l'utilisateur
        if ($user->role_name === 'Admin') {
            // Récupérer tous les emplois du temps et les classes
            $schedules = Schedule::with(['subject', 'teacher', 'class'])->get();
            $classes = Classe::all();
        } elseif ($user->role_name === 'Teacher') {
            // Récupérer les emplois du temps du professeur
            $schedules = Schedule::with(['subject', 'teacher', 'class'])
                ->where('teacher_id', $user->teacher->id)
                ->get();
            $classes = Classe::all();
        } elseif ($user->role_name === 'Student') {
            // Récupérer les emplois du temps des classes de l'étudiant
            $student = $user->student;
            $classIds = $student->classes->pluck('id');
            $schedules = Schedule::with(['subject', 'teacher', 'class'])
                ->whereIn('class_id', $classIds)
                ->get();
        } else {
            abort(403, 'Unauthorized action.');
        }

        // Retourner la vue avec les emplois du temps et les classes
        return view('schedules.index', compact('schedules', 'classes'));
    }

    // Afficher le formulaire de création d'un emploi du temps
    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();

        return view('schedules.create', compact('subjects', 'teachers', 'classes'));
    }

    // Enregistrer un nouvel emploi du temps
    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps créé avec succès.');
    }

    // Afficher le formulaire de modification d'un emploi du temps
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();

        return view('schedules.edit', compact('schedule', 'subjects', 'teachers', 'classes'));
    }

    // Mettre à jour un emploi du temps
    public function update(Request $request, $id)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps mis à jour avec succès.');
    }

    // Supprimer un emploi du temps
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }

    // Filtrer les emplois du temps par classe
    public function filterByClass(Request $request)
    {
        $class_id = $request->get('class_id');
        $classes = SchoolClass::all(); // Récupérer toutes les classes
        $schedules = Schedule::where('class_id', $class_id)->get(); // Filtrer les emplois du temps par classe
        $selectedClass = SchoolClass::find($class_id);

        return view('schedules.index', compact('schedules', 'classes', 'selectedClass'));
    }
}
