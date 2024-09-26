<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    /** Afficher tous les utilisateurs */
    public function userView()
    {
        $users = User::all();
        return view('usermanagement.list_users', compact('users'));
    }

    // UserController.php
    public function getUsersData()
    {
        $users = User::all()->map(function($user) {
            return [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'date_of_birth' => $user->date_of_birth,
                'join_date' => $user->join_date,
                'phone_number' => $user->phone_number,
                'status' => $user->status,
                'role_name' => $user->role_name,
                'avatar' => $user->avatar,
                'position' => $user->position,
                'department' => $user->department,
                'modify' => '<button class="btn btn-edit" data-id="'.$user->id.'">Modifier</button>' // Exemple de bouton de modification
            ];
        });

        return response()->json(['data' => $users]);
    }



    /** Formulaire pour ajouter un utilisateur */
    public function userCreate()
    {
        return view('usermanagement.add_user');
    }

    /** Ajouter un nouvel utilisateur */
    public function userAdd(Request $request)
    {
        // Validation des données d'entrée
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'role_name'     => 'required|string',
            'position'      => 'nullable|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'department'    => 'nullable|string|max:255',
            'status'        => 'required|string',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Gestion de l'upload de l'image
            $image_name = 'photo_defaults.jpg'; // Image par défaut

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $image_name = time() . '.' . $image->getClientOriginalExtension(); // Utilisation du timestamp pour éviter les conflits
                $image->move(public_path('/images/'), $image_name);
            }

            // Création d'un nouvel utilisateur
              $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'role_name'     => $request->role_name,
                'position'      => $request->position,
                'phone_number'  => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'department'    => $request->department,
                'status'        => $request->status,
                'avatar'        => $image_name,
                'password'      => Hash::make('defaultpassword123'), // Mot de passe par défaut à changer
            ]);
            Mail::to($user->email)->send(new AccountCreated($user));
            DB::commit();
            Toastr::success('Utilisateur ajouté avec succès :)', 'Succès');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Échec de l\'ajout de l\'utilisateur: ' . $e->getMessage(), 'Erreur');
            return redirect()->back();
        }
    }

    /** Formulaire de modification d'un utilisateur */
    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('usermanagement.edit_user', compact('user'));
    }

    /** Mettre à jour les informations d'un utilisateur */
    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $id,
            'role_name'     => 'required|string',
            'position'      => 'nullable|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'department'    => 'nullable|string|max:255',
            'status'        => 'required|string',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        // Gestion de l'upload de l'image
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/images/'), $image_name);
            $user->avatar = $image_name; // Mettre à jour l'avatar
        }

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'role_name'     => $request->role_name,
            'position'      => $request->position,
            'phone_number'  => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'department'    => $request->department,
            'status'        => $request->status,
        ]);

        Toastr::success('Utilisateur mis à jour avec succès :)', 'Succès');
        return redirect()->route('user.view');
    }

    /** Supprimer un utilisateur */
    public function userDelete($id)
    {
        $user = User::findOrFail($id);

        // Supprimer l'avatar du système de fichiers si nécessaire
        if ($user->avatar != 'photo_defaults.jpg') {
            @unlink(public_path('/images/' . $user->avatar));
        }

        $user->delete();

        Toastr::success('Utilisateur supprimé avec succès :)', 'Succès');
        return redirect()->back();
    }
}
