<?php

namespace App\Http\Controllers;

use App\Models\Classe; // Import the Classe model
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /** List of classes */
    public function classList()
    {
        $classes = Classe::all();
        return view('classes.classe_list', compact('classes'));
    }

    /** Display classes in grid */
    public function grid()
    {
        $classes = Classe::all();
        return view('classes.grid', compact('classes'));
    }

    /** Form to add a class */
    public function classAdd()
    {
        return view('classes.class_add');
    }

    /** Save a class */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Create the class
            $classe = new Classe();
            $classe->class_name = $request->class_name;
            $classe->save();

            Toastr::success('The class has been added successfully :)', 'Success');
            DB::commit();
            return redirect()->route('class/list/page'); // Redirect to the list of classes

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add the class :)', 'Error');
            return redirect()->back();
        }
    }

    /** Form to edit a class */
    public function classEdit($id)
    {
        $class = Classe::findOrFail($id);
        return view('classes.class_edit', compact('class'));
    }

    /** Update a class */
    public function updateRecord(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Retrieve the class to update
            $classe = Classe::findOrFail($id);
            $classe->class_name = $request->class_name;
            $classe->save();

            Toastr::success('The class has been updated successfully :)', 'Success');
            DB::commit();
            return redirect()->route('class/list/page'); // Redirect to the list of classes

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update the class :)', 'Error');
            return redirect()->back();
        }
    }

    /** Delete a class */
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {
            $classe = Classe::findOrFail($request->id);
            $classe->delete();
            DB::commit();
            Toastr::success('The class has been deleted successfully :)', 'Success');
            return redirect()->route('class/list/page'); // Redirect to the list of classes

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete the class :)', 'Error');
            return redirect()->back();
        }
    }

    /** Display the profile of a class */
    public function show($id)
    {
        $classe = Classe::findOrFail($id);
        return view('classes.show', compact('classe'));
    }
}
