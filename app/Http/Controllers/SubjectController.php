<?php

namespace App\Http\Controllers;

use App\Models\Subject; // Import du modèle Subject
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /** Liste des matières */
    public function subjectList()
    {
        $subjects = Subject::all();
        return view('subjects.subject_list', compact('subjects'));
    }

    /** Affichage des matières en grille */
    public function grid()
    {
        $subjects = Subject::all();
        return view('subject.grid', compact('subjects'));
    }

    /** Formulaire d'ajout d'une matière */
    public function subjectAdd ()
    {
        return view('subjects.subject_add');
    }

    /** Sauvegarde d'une matière */
    public function saveRecord(Request $request)
    {
//        dd($request);
        $request->validate([
//            'subject_id'   => 'required|string|unique:subjects,subject_id',
            'subject_name' => 'required|string',
            // Aucune classe associée à la matière dans ce cas
        ]);

        DB::beginTransaction();
        try {
            // Créer la matière
            $subject = new Subject();
            $subject->subject_id = $request->subject_id;
            $subject->subject_name = $request->subject_name;
            $subject->save();

            Toastr::success('La matière a été ajoutée avec succès :)', 'Succès');
            DB::commit();
            return redirect()->route('subject/list/page'); // Redirige vers la liste des matières

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de l\'ajout de la matière :)', 'Erreur');
            return redirect()->back();
        }
    }

    /** Formulaire de modification d'une matière */
    public function subjectEdit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subjects.subject_edit', compact('subject'));
    }

    /** Mise à jour d'une matière */
    public function updateRecord(Request $request, $id)
    {
        $request->validate([
            'subject_id'   => 'required|string|unique:subjects,subject_id,' . $id,
            'subject_name' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Récupérer la matière à mettre à jour
            $subject = Subject::findOrFail($id);
            $subject->subject_id = $request->subject_id;
            $subject->subject_name = $request->subject_name;
            $subject->save();

            Toastr::success('La matière a été mise à jour avec succès :)', 'Succès');
            DB::commit();
            return redirect()->route('subject/list/page'); // Redirige vers la liste des matières

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de la mise à jour de la matière :)', 'Erreur');
            return redirect()->back();
        }
    }

    /** Suppression d'une matière */
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            $subject = Subject::findOrFail($request->id);
            $subject->delete();
            DB::commit();
            Toastr::success('La matière a été supprimée avec succès :)', 'Succès');
            return redirect()->route('subject/list/page'); // Redirige vers la liste des matières

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de la suppression de la matière :)', 'Erreur');
            return redirect()->back();
        }
    }

    /** Affichage du profil d'une matière */
    public function show($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subject.show', compact('subject'));
    }
}
