<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    /** Display a list of grades */
    public function index($classId)
    {
        // Récupérer la classe sélectionnée
        $class = Classe::with('students.grades')->find($classId);

        if (!$class) {
            return redirect()->route('teacher.classe')->with('error', 'Classe non trouvée.');
        }

        // Récupérer les étudiants de la classe et leurs notes
        $students = $class->students;
        $grades = Grade::with(['student', 'subject'])->whereIn('student_id', $students->pluck('id'))->get();
        $subjects = Subject::all();

        return view('grades.list_grade', compact('students', 'class', 'grades', 'subjects'));
    }

    /** Show the form to add a new grade */
    public function create()
    {
        $students = Student::all(); // Récupérer tous les étudiants
        $subjects = Subject::all(); // Récupérer toutes les matières
        return view('grade.add-grade', compact('students', 'subjects'));
    }

    /** Store a new grade */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'evaluation_type' => 'required|string|max:255', // Validation pour evaluation_type
            'grade'      => 'required|numeric|min:0|max:100',
            'comment'    => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            Grade::create([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'evaluation_type' => $request->evaluation_type, // Ajout de evaluation_type
                'grade'      => $request->grade,
                'comment'    => $request->comment,
            ]);

            DB::commit();
            Toastr::success('Grade added successfully :)', 'Success');
            return redirect()->route('grades.index', ['classId' => $request->class_id]);

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add grade: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Show the form to edit a grade */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $students = Student::all(); // Récupérer tous les étudiants
        $subjects = Subject::all(); // Récupérer toutes les matières
        return view('grade.edit-grade', compact('grade', 'students', 'subjects'));
    }

    /** Update a grade */
    public function update(Request $request)
    {
        // Validation des données
        $request->validate([
            'grade_id'   => 'required|exists:grades,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'evaluation_type' => 'required|string|max:255',
            'grade'      => 'required|numeric|min:0|max:100',
            'comment'    => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $grade = Grade::findOrFail($request->grade_id);
            $grade->update([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'evaluation_type' => $request->evaluation_type,
                'grade'      => $request->grade,
                'comment'    => $request->comment,
            ]);

            DB::commit();
            Toastr::success('Note mise à jour avec succès :)', 'Succès');
            return redirect()->route('grades.index', ['classId' => $grade->student->class_id]);

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de la mise à jour de la note : ' . $e->getMessage(), 'Erreur');
            return redirect()->back();
        }
    }

    /** Delete a grade */


    public function destroy(Request $request)
    {
        $id = $request->input('id');
        DB::beginTransaction();
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();

            DB::commit();
            Toastr::success('Note supprimée avec succès :)', 'Succès');
            return redirect()->route('grades.index', ['classId' => $grade->student->class_id]);

        } catch (\Exception $e) {
            DB::rollback();

            Toastr::error('Échec de la suppression de la note: ' . $e->getMessage(), 'Erreur');
            return redirect()->back();
        }
    }



    /** Show details of a specific grade */
    public function show()
    {
        $student = auth()->user()->student; // Assurez-vous que l'utilisateur est authentifié et qu'il a un étudiant associé
        $grades = $student->grades()->with('subject')->get(); // Récupérer les notes de l'étudiant avec les matières associées
        return view('grades.my-grades', compact('grades'));
    }
}
