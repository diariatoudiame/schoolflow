<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classe;
use App\Models\Schedule;
use App\Models\Student;


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{

    public function index($classId)
    {
        // Récupérer la classe par son ID
        $class = Classe::findOrFail($classId);

        // Récupérer les étudiants associés à cette classe via la relation many-to-many
        $students = $class->students;

        // Récupérer les horaires associés à cette classe
        $schedules = $class->schedules;

        // Récupérer les enregistrements d'assiduité pour les étudiants de la classe
        $attendances = Attendance::whereIn('student_id', $students->pluck('id'))->get();

        // Préparer les données d'assiduité pour l'affichage
        $attendanceData = [];
        foreach ($attendances as $attendance) {
            $attendanceData[$attendance->student_id] = $attendance->status;
        }

        // Retourner la vue avec la classe, les étudiants, les horaires et les données d'assiduité
        return view('attendance.index', compact('class', 'students', 'schedules', 'attendanceData'));
    }



    // ... other methods ...

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        $date = Carbon::parse($request->date);

        // Get the day of the week directly from the schedule
        $scheduleDayInEnglish = $schedule->day_of_week;

        if ($scheduleDayInEnglish === null) {
            return back()->with('error', "The course's day of the week is not valid.");
        }

        // Compare the day of the week of the date with the schedule
        if ($date->englishDayOfWeek !== $scheduleDayInEnglish) {
            return back()->with('error', 'The date does not match the course’s day of the week.');
        }

        try {
            foreach ($request->attendance as $attendanceData) {
                Attendance::updateOrCreate(
                    [
                        'schedule_id' => $request->schedule_id,
                        'date' => $request->date,
                        'student_id' => $attendanceData['student_id'],
                    ],
                    [
                        'status' => $attendanceData['status'],
                    ]
                );
            }
            return redirect()->route('teacher.classe.attendance', $schedule->class_id)->with('success', 'Attendance marked successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function downloadAttendancePDF($classId)
    {
        // Récupérer la classe par son ID
        $class = Classe::findOrFail($classId);

        // Récupérer les étudiants associés à cette classe
        $students = $class->students;

        // Récupérer les enregistrements d'assiduité
        $attendances = Attendance::whereIn('student_id', $students->pluck('id'))->get();

        // Regrouper les étudiants par statut
        $presentStudents = $attendances->where('status', 'present');
        $absentStudents = $attendances->where('status', 'absent');
        $lateStudents = $attendances->where('status', 'late');

        // Préparer les données pour le PDF
        $data = [
            'class' => $class,
            'presentStudents' => $presentStudents,
            'absentStudents' => $absentStudents,
            'lateStudents' => $lateStudents,
        ];

        // Générer le PDF
        $pdf = PDF::loadView('attendance.pdf', $data);

        // Retourner le PDF en téléchargement
        return $pdf->download('attendance_' . $class->class_name . '.pdf');
    }


}
