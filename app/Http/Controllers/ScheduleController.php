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

    
    // Méthode pour afficher la page de sélection de classe


    public function index()
    {
        // Obtenir l'utilisateur connecté
        $user = auth()->user();
    
        // Initialisation de la variable $classes
        $classes = null;
    
        // Vérifier si l'utilisateur est un admin, teacher ou étudiant
        if ($user->role_name === 'Admin') {
            // Si c'est un admin, récupérer tous les cours
            $schedules = Schedule::with(['subject', 'teacher', 'class'])->get();
            // Récupérer toutes les classes
            $classes = Classe::all();
        } elseif ($user->role_name === 'Teacher') {
            // Si c'est un teacher, récupérer uniquement ses propres cours
            // $schedules = Schedule::with(['subject', 'teacher', 'class'])
            //     ->where('teacher_id', $user->teacher->id)
            //     ->get();
            $schedules = Schedule::with(['subject', 'teacher', 'class'])->get();
            // Récupérer toutes les classes
            $classes = Classe::all();
        } elseif ($user->role_name === 'Student') {
            // Si c'est un étudiant, récupérer l'emploi du temps de toutes ses classes
            $student = $user->student; // Assurez-vous que l'utilisateur a une relation 'student'
            
            // Récupérer toutes les classes de l'étudiant
            $classIds = $student->classes->pluck('id'); // Assurez-vous que la relation 'classes' est définie
            
            // Récupérer l'emploi du temps pour toutes les classes de l'étudiant
            $schedules = Schedule::with(['subject', 'teacher', 'class'])
                ->whereIn('class_id', $classIds) // Filtrer par les IDs des classes
                ->get();
        } else {
            // Si l'utilisateur n'est ni un admin, ni un teacher, ni un student
            abort(403, 'Unauthorized action.');
        }
    
        // Retourne la vue avec les données nécessaires
        return view('schedules.index', compact('schedules', 'classes'));
    }
    

// public function index()
// {
//     $classes = SchoolClass::all(); // Récupérer toutes les classes
//     $schedules = Schedule::all(); // Tous les emplois du temps


//     return view('schedules.index', compact('schedules', 'classes'));
// }

 
    public function createForClass(Request $request)
    {
        $class_id = $request->get('class_id'); // Récupérer l'identifiant de la classe sélectionnée
        $class = SchoolClass::findOrFail($class_id);
        $subjects = Subject::all();
        $teachers = Teacher::all();

        return view('schedules.create', compact('subjects', 'teachers', 'class'));
    }


        // Méthode store  pour inclure class_id
        public function store(Request $request)
        {
            $request->validate([
                'day_of_week' => 'required|string',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
                'subject_id' => 'required|exists:subjects,id',
                'teacher_id' => 'required|exists:teachers,id',
                'class_id' => 'required|exists:classes,id', // Validation pour class_id
            ]);
    
            Schedule::create([
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
                'class_id' => $request->class_id, // Enregistrement de la classe
            ]);
    
            return redirect()->route('schedules.index')->with('success', 'Emploi du temps créé avec succès.');
        }



    // public function index()
    // {
    //     $schedules = Schedule::with(['subject', 'teacher'])->get();
    //     return view('schedules.index', compact('schedules'));
    // }

    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();
        return view('schedules.create', compact('subjects', 'teachers', 'classes'));
    }
    
    public function filterByClass(Request $request)
    {
        $class_id = $request->get('class_id');
        $classes = SchoolClass::all(); // Récupérer toutes les classes pour afficher dans le menu déroulant
        $schedules = Schedule::where('class_id', $class_id)->get(); // Filtrer les emplois du temps par classe

        // Passer la classe sélectionnée pour l'afficher dans la vue
        $selectedClass = SchoolClass::find($class_id);

        return view('schedules.index', compact('schedules', 'classes', 'selectedClass'));
    }

    public function selectClass()
    {
        // Récupérer toutes les classes
        $classes = SchoolClass::all();

        return view('schedules.select_class', compact('classes'));
    }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'day_of_week' => 'required|string',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //         'subject_id' => 'required|exists:subjects,id',
    //         'teacher_id' => 'required|exists:teachers,id',
    //         'class_id' => 'required|exists:classes,id'
    //     ]);

    //     Schedule::create($request->all());
    //     return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    // }


    public function update(Request $request, $id)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id'
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps mis à jour avec succès.');
    }


    
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = SchoolClass::all();
        return view('schedules.edit', compact('schedule', 'subjects', 'teachers', 'classes'));
    }


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }



}
