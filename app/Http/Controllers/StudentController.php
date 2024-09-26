<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Student;
use App\Models\User; // Import User model
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash for password

class StudentController extends Controller
{
    /** List of students */
    public function student()
    {
        $studentList = Student::all();
        return view('student.student', compact('studentList'));
    }

    /** Display students in grid view */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid', compact('studentList'));
    }

    /** Student add form */
    public function studentAdd()
    {
        $classes = Classe::all();
        return view('student.add-student', compact('classes'));
    }

    /** Save a student */
    public function studentSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|date',
            'roll'          => 'required|string|unique:students,roll',
            'blood_group'   => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'phone_number'  => 'required',
            'upload'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'class_id'      => 'required|exists:classes,id',
            'academic_year' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Handle the uploaded image
            $upload_file = time() . '_' . $request->upload->extension();
            $path = $request->upload->storeAs('student-photos', $upload_file, 'public');

            // Create a user for the student
            $user = new User;
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make('passer@12');
            $user->role_name = 'Student';
            $user->save();

            // Create the student and associate the user_id
            $student = new Student;
            $student->user_id = $user->id;
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->gender = $request->gender;
            $student->date_of_birth = $request->date_of_birth;
            $student->roll = $request->roll;
            $student->blood_group = $request->blood_group;
            $student->phone_number = $request->phone_number;
            $student->upload = $path;
            $student->save();

            // Attach the student to classes and academic year
            $student->classes()->attach($request->class_id, ['academic_year' => $request->academic_year]);

            DB::commit();
            Toastr::success('Student and user account successfully added :)', 'Success');
            return redirect()->route('student/list');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add student: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /** Edit student form */
    public function studentEdit($id)
    {
        $student = Student::findOrFail($id);
        $classes =  Classe::all();
        return view('student.edit-student', compact('student', 'classes'));
    }

    /** Update a student */
    public function studentUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'phone_number'  => 'required',
            'upload'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'class_id'      => 'nullable|exists:classes,id',
            'academic_year' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Retrieve the student to be updated
            $student = Student::findOrFail($id);

            // Check if a new image file has been uploaded
            if ($request->hasFile('upload')) {
                // Delete the old image if it exists
                if ($student->upload && file_exists(storage_path('app/public/' . $student->upload))) {
                    unlink(storage_path('app/public/' . $student->upload));
                }
                // Store the new image
                $upload_file = time() . '.' . $request->upload->extension();
                $path = $request->upload->storeAs('student-photos', $upload_file, 'public');
                $student->upload = $path;
            }

            // Update other fields
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->phone_number = $request->phone_number;
            $student->date_of_birth = $request->date_of_birth;
            $student->save();

            // Update the association with classes if 'class_id' is present
            if ($request->class_id) {
                $student->classes()->sync([$request->class_id => ['academic_year' => $request->academic_year]]);
            }

            Toastr::success('Student successfully updated :)', 'Success');
            DB::commit();
            return redirect()->route('student/list');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update student: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Delete a student */
    public function studentDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $teacher = Student::findOrFail($request->id);

            // Supprimez l'avatar de l'enseignant si il existe
            if ($request->avatar && file_exists(storage_path('app/public/' . $request->avatar))) {
                unlink(storage_path('app/public/' . $request->avatar));
            }

            $teacher->delete();

            DB::commit();
            Toastr::success('Teacher successfully updated :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete the teacher : ' . $e->getMessage(), 'Erreur');
            return redirect()->back();
        }
    }

    /** Display student profile */
    public function studentProfile($id)
    {
        $studentProfile = Student::findOrFail($id);
        return view('student.student-profile', compact('studentProfile'));
    }
}
