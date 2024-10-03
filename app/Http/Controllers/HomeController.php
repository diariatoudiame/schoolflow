<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    /** home dashboard */
//    public function index()
//    {
//        return view('dashboard.home');
//    }

      public function index()
      {
          $nbr_students = Student::count();
          $nbr_classes = Classe::count(); // Remplacez 'Classe' par le nom correct de votre modèle de classe
          $nbr_teachers = Teacher::count();

          // Passer les valeurs à la vue
          return view('dashboard.home', compact('nbr_students', 'nbr_classes', 'nbr_teachers'));

      }



    /** profile user */
    public function userProfile()
    {
        return view('dashboard.profile');
    }

    /** teacher dashboard */
    public function teacherDashboardIndex()
    {
        return view('dashboard.teacher_dashboard');
    }

    /** student dashboard */
    public function studentDashboardIndex()
    {
        return view('dashboard.student_dashboard');
    }
}
