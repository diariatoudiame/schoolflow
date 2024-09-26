<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User; // Import the User model
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TeacherController extends Controller
{
    /** Display all teachers */
    public function teacherList()
    {
        $teachers = Teacher::all();
        return view('teacher.list-teachers', compact('teachers'));
    }

//    edit my profile



    /** Display details of a teacher */
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teacher.infos-teacher', compact('teacher'));
    }

    /** Form to add a teacher */
    public function teacherAdd()
    {
        return view('teacher.add-teacher');
    }

    /** Add a new teacher */
    public function saveRecord(Request $request)
    {
        // Validate input data
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email', // Email validation for the user account
            'gender'        => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'qualification' => 'nullable|string|max:255',
            'experience'    => 'nullable|integer',
            'phone_number'  => 'nullable|string|max:20',
            'address'       => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create a new user for the teacher
            $user = User::create([
                'name'     => $request->full_name,
                'email'    => $request->email,
                'password' => Hash::make('passer@12'), // Default password
                'role_name' => 'Teacher', // Ensure this matches your role structure
                'join_date' => now(), // Ensure this matches your role structure
            ]);
            Mail::to($user->email)->send(new AccountCreated($user));

            // Create the new teacher
            Teacher::create([
                'user_id'       => $user->id,
                'full_name'     => $request->full_name,
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'qualification' => $request->qualification,
                'experience'    => $request->experience,
                'phone_number'  => $request->phone_number,
                'address'       => $request->address,
            ]);

            DB::commit();
            Toastr::success('Teacher and user account created successfully :)', 'Success');
            return redirect()->route('teacher/list/page');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to create the teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Form to edit a teacher */
    public function editRecord($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teacher.edit-teacher', compact('teacher'));
    }

//    view my profile
    public function editProfile()
    {
        // Récupérer les informations de l'enseignant connecté
        $teacher = auth()->user()->teacher;

        return view('teacher.teacher-profile', compact('teacher'));
    }


//    update my profile
    public function update(Request $request)
    {
        // Récupérer l'enseignant connecté
        $teacher = auth()->user()->teacher;

        // Validation des données
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'qualification' => 'required|string',
            'experience' => 'required|integer',
            'phone_number' => 'required|string',
            'address' => 'required|string',
        ]);

        // Mise à jour des données
        $teacher->update($request->only([
            'full_name', 'gender', 'date_of_birth', 'qualification', 'experience', 'phone_number', 'address'
        ]));

        // Mise à jour de l'adresse e-mail de l'utilisateur associé
        $teacher->user->update(['email' => $request->email]);

        return redirect()->route('teacher.space')->with('success', 'Profile updated successfully');
    }


    /** Update a teacher's information */
    public function updateRecordTeacher(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|',  // Ignore the current user for validation
//            'email'         => 'required|email|unique:users,email,' . $id, // Ignore the current user for validation
            'gender'        => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'qualification' => 'nullable|string|max:255',
            'experience'    => 'nullable|integer',
            'phone_number'  => 'nullable|string|max:20',
            'address'       => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $teacher = Teacher::findOrFail($id);
            $teacher->update([
                'full_name'     => $request->full_name,
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'qualification' => $request->qualification,
                'experience'    => $request->experience,
                'phone_number'  => $request->phone_number,
                'address'       => $request->address,
            ]);

            // Update the associated user's information
            $user = User::findOrFail($teacher->user_id);
            $user->update([
                'name'  => $request->full_name,
                'email' => $request->email,
            ]);

            DB::commit();
            Toastr::success('Teacher updated successfully :)', 'Success');
            return redirect()->route('teacher/list/page');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update the teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Delete a teacher */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $teacher = Teacher::findOrFail($id);

            // Also delete the associated user
            if ($teacher->user_id) {
                $user = User::findOrFail($teacher->user_id);
                $user->delete();
            }

            $teacher->delete();

            DB::commit();
            Toastr::success('Teacher deleted successfully :)', 'Success');
            return redirect()->route('teachers.index');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete the teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
