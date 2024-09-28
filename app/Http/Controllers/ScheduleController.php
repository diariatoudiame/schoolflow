<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
//    public function index()
//    {
//        $schedules = Schedule::with(['subject', 'teacher'])->get();
//        return view('schedules.index', compact('schedules'));
//    }

    public function index()
    {
        // Obtenir l'utilisateur connecté
        $user = auth()->user();
        $teacher = auth()->user()->teacher;

        // Vérifier si l'utilisateur est un teacher ou un admin
        if ($user->role_name === 'Admin') {
            // Si c'est un admin, récupérer tous les cours
            $schedules = Schedule::with(['subject', 'teacher', 'class'])->get();
        } elseif ($user->role_name === 'Teacher') {
            // Si c'est un teacher, récupérer uniquement ses propres cours
            $schedules = Schedule::with(['subject', 'teacher', 'class'])
                ->where('teacher_id', $teacher->id)
                ->get();
        } else {
            // Si l'utilisateur n'est ni un admin ni un teacher, pas d'accès
            abort(403, 'Unauthorized action.');
        }

        return view('schedules.index', compact('schedules'));
    }




    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes = Classe::all();
        return view('schedules.create', compact('subjects', 'teachers','classes'));
    }
    
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
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }


    public function update(Request $request, $id)
    {
        \Log::info('Début de la méthode update pour l\'emploi du temps ID: ' . $id);
        \Log::info('Données reçues:', $request->all());

        try {
            $validatedData = $request->validate([
                'day_of_week' => 'required|string',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s|after:start_time',
                'subject_id' => 'required|exists:subjects,id',
                'teacher_id' => 'required|exists:teachers,id',
                'class_id' => 'required|exists:classes,id',
            ]);

            \Log::info('Données validées avec succès:', $validatedData);

            $schedule = Schedule::findOrFail($id);
            \Log::info('Emploi du temps trouvé:', $schedule->toArray());

            $updated = $schedule->update($validatedData);

            if ($updated) {
                \Log::info('Mise à jour réussie pour l\'emploi du temps ID: ' . $id);
                \Log::info('Nouvel état de l\'emploi du temps:', $schedule->fresh()->toArray());
                return redirect()->route('schedules.index')->with('success', 'Emploi du temps mis à jour avec succès.');
            } else {
                \Log::error('Échec de la mise à jour pour l\'emploi du temps ID: ' . $id);
                return back()->with('error', 'La mise à jour a échoué. Veuillez réessayer.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Emploi du temps non trouvé pour l\'ID: ' . $id);
            return back()->with('error', 'Emploi du temps non trouvé.');
        } catch (\Exception $e) {
            \Log::error('Exception inattendue lors de la mise à jour de l\'emploi du temps ID ' . $id . ': ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()->with('error', 'Une erreur inattendue s\'est produite. Veuillez réessayer.');
        }
    }



    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classes =  Classe::all();

        return view('schedules.edit', compact('schedule', 'subjects', 'teachers','classes'));
    }


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }

}
