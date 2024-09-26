<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User; // Import du modèle User
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import de Hash pour le mot de passe

class StudentController extends Controller
{
    /** Liste des étudiants */
    public function student()
    {
        $studentList = Student::all();
        return view('student.student', compact('studentList'));
    }

    /** Affichage des étudiants en grille */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid', compact('studentList'));
    }

    /** Formulaire d'ajout d'un étudiant */
    public function studentAdd()
    {
        return view('student.add-student');
    }

    /** Sauvegarde d'un étudiant */
    public function studentSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|date',
            'roll'          => 'required|string',
            'blood_group'   => 'required|string',
            'email'         => 'required|email|unique:students,email|unique:users,email',
            'phone_number'  => 'required',
            'upload'        => 'required|image',
        ]);

        DB::beginTransaction();
        try {
            // Gestion de l'image téléchargée
            $upload_file = rand() . '.' . $request->upload->extension();
            $path = $request->upload->storeAs('student-photos', $upload_file, 'public');

            // Créer un utilisateur pour l'étudiant
            $user = new User;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make('passer@12'); // Définissez un mot de passe par défaut
            $user->role_name = 'Student'; // Définissez un mot de passe par défaut
            $user->save();

            // Créer l'étudiant et associer le user_id
            $student = new Student;
            $student->user_id = $user->id; // Associer l'utilisateur à l'étudiant
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->gender = $request->gender;
            $student->date_of_birth = $request->date_of_birth;
            $student->roll = $request->roll;
            $student->blood_group = $request->blood_group;
            $student->email = $request->email;
            $student->phone_number = $request->phone_number;
            $student->upload = $path;
            $student->save();

            Toastr::success('L\'étudiant et le compte utilisateur ont été ajoutés avec succès :)', 'Succès');
            DB::commit();
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de l\'ajout de l\'étudiant et de la création de l\'utilisateur :)', 'Erreur');
            return redirect()->back();
        }
    }

    /** Formulaire de modification d'un étudiant */
    public function studentEdit($id)
    {
        $studentEdit = Student::findOrFail($id);
        return view('student.edit-student', compact('studentEdit'));
    }

    /** Mise à jour d'un étudiant */
    /** Mise à jour d'un étudiant */
    public function studentUpdate(Request $request)
    {
//        dd($request);
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|email' ,
            'phone_number'  => 'required',
            'upload'        => 'nullable|image',
            'date_of_birth'        => 'nullable|date',
        ]);

        DB::beginTransaction();
        try {
            // Récupérer l'étudiant à mettre à jour
            $student = Student::findOrFail($request->id);

            // Vérifiez si un nouveau fichier d'image a été téléchargé
            if ($request->hasFile('upload')) {
                // Supprimer l'ancienne image si elle existe
                if ($student->upload) {
                    unlink(storage_path('app/public/student-photos/' . $student->upload));
                }
                // Stocker la nouvelle image
                $upload_file = rand() . '.' . $request->upload->extension();
                $path = $request->upload->storeAs('student-photos', $upload_file, 'public');
                $student->upload = $path; // Mettre à jour le champ upload
            }

            // Mettre à jour les autres champs
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->phone_number = $request->phone_number;
            $student->date_of_birth = $request->date_of_birth;
            $student->save(); // Enregistrez les modifications

            Toastr::success('L\'étudiant a été mis à jour avec succès :)', 'Succès');
            DB::commit();
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de la mise à jour de l\'étudiant :)', 'Erreur');
            return redirect()->back();
        }
    }


    /** Suppression d'un étudiant */
    public function studentDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($request->id);
            if ($student->upload) {
                unlink(storage_path('app/public/student-photos/' . $student->upload));
            }
            $student->delete();
            DB::commit();
            Toastr::success('L\'étudiant a été supprimé avec succès :)', 'Succès');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de la suppression de l\'étudiant :)', 'Erreur');
            return redirect()->back();
        }
    }

    /** Affichage du profil d'un étudiant */
    public function studentProfile($id)
    {
        $studentProfile = Student::findOrFail($id);
        return view('student.student-profile', compact('studentProfile'));
    }
}
