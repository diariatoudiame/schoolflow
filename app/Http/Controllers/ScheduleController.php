<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['subject', 'teacher'])->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('schedules.create', compact('subjects', 'teachers'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        Schedule::create($request->all());
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
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

        return view('schedules.edit', compact('schedule', 'subjects', 'teachers'));
    }


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }

}
