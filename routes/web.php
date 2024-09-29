<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    Route::get('home',function()
    {
        return view('home');
    });
});

Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // ----------------------------login ------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login'); 
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('change/password', 'changePassword')->name('change/password');
    });

    // ----------------------------- register -------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });
});


//------------------------------Change password--------------------------//
Route::post('/change-password', [UserManagementController::class, 'changePassword'])->name('change.password');


Route::group(['namespace' => 'App\Http\Controllers'],function()
{
    // -------------------------- main dashboard ----------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->middleware('auth')->name('home');
        Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
        Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
        Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
    });

    // ----------------------------- user controller ---------------------//
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('list/users', 'userView')->middleware('auth')->name('list/users');
        Route::post('change/password', 'changePassword')->name('change/password');
        Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
        Route::get('get-users-data', 'getUsersData')->name('get-users-data'); 

        Route::post('/user/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('user.toggleStatus');


    });

    // ------------------------ setting -------------------------------//
    Route::controller(Setting::class)->group(function () {
        Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
    });

    // ------------------------ student -------------------------------//
    Route::controller(StudentController::class)->group(function () {
        Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
        Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
        Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
        Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
        Route::get('student/edit/{id}', 'studentEdit'); // view for edit
        Route::put('student/update/{id}', 'studentUpdate')->name('student/update'); // update record student
        Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
        Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
    });

    // ------------------------ teacher -------------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teacher/add/page', 'teacherAdd')->middleware('auth')->name('teacher/add/page'); // page teacher
        Route::get('teacher/list/page', 'teacherList')->middleware('auth')->name('teacher/list/page'); // page teacher
        Route::get('teacher/grid/page', 'teacherGrid')->middleware('auth')->name('teacher/grid/page'); // page grid teacher
        Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); // save record
        Route::get('teacher/edit/{id}', 'editRecord')->name('teacher/s'); ; // view teacher record
        Route::get('teacher/infos/{id}', 'show')->name('teacher/infos'); ; // view teacher record
        Route::put('teacher/update/{id}', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); // update record
//        Route::put('/teachers/{id}', [TeacherController::class, 'updateRecordTeacher'])->name('teacher.update');
        Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
        //New
        Route::put('teacher/profile',  'update')->name('teacher.profile.update');
        Route::get('/teacher/profile/edit', 'editProfile')->name('teacher.profile.edit');


        //-----------------------Schedules-----------------------------------//
        
        Route::get('/admin/calendar', [ScheduleController::class, 'index'])->name('admin.calendar');
        Route::put('/admin/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/admin/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
        Route::get('schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');


        Route::get('/schedules/select-class', [ScheduleController::class, 'selectClass'])->name('schedules.selectClass');
        Route::get('/schedules/create-for-class', [ScheduleController::class, 'createForClass'])->name('schedules.create.forClass');
        Route::get('/schedules/class', [ScheduleController::class, 'filterByClass'])->name('schedules.filterByClass');
        
        Route::resource('schedules', ScheduleController::class);

        Route::prefix('admin')->group(function () {
            Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
            Route::get('schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
            Route::post('schedules', [ScheduleController::class, 'store'])->name('schedules.store');
            Route::get('schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
            Route::put('schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
            Route::delete('schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
            Route::resource('schedules', ScheduleController::class);
            
        });



    });
    Route::get('/teacher/space', function () {
        return view('teacher.space-teacher'); 
    })->name('teacher.space');
    // ------------------------ book -------------------------------//
    Route::controller(BookController::class)->group(function () {
        Route::get('book/add/page', 'bookAdd')->middleware('auth')->name('book/add/page'); // page for adding a book
        Route::get('book/list/page', 'bookList')->middleware('auth')->name('book/list/page'); // page for listing books
        Route::get('book/grid/page', 'bookGrid')->middleware('auth')->name('book/grid/page'); // page for grid view of books
        Route::post('book/save', 'saveRecord')->middleware('auth')->name('book/save'); // save book record
        Route::get('book/edit/{id}', 'editRecord')->name('book/edit'); // view book record for editing
        Route::get('book/infos/{id}', 'show')->name('book/infos'); // view detailed information of a book
        Route::put('book/update/{id}', 'updateRecordBook')->middleware('auth')->name('book/update'); // update book record
        Route::post('book/delete', 'bookDelete')->name('book/delete'); // delete book record
        Route::get('/books/search', 'searchBooks')->name('books.search');

    });


    // Routes pour les réservations
    Route::controller(ReservationController::class)->group(function () {
        Route::get('reservations', 'index')->middleware('auth')->name('reservations.index'); // Liste des réservations
        Route::get('reservations/create/{i}', 'create')->middleware('auth')->name('reservations.create'); // Formulaire de réservation
        Route::post('reservations', 'store')->middleware('auth')->name('reservations.store'); // Enregistrer une nouvelle réservation
        Route::get('reservations/{id}', 'show')->middleware('auth')->name('reservations.show'); // Afficher une réservation spécifique
        Route::get('reservations/{id}/edit', 'edit')->middleware('auth')->name('reservations.edit'); // Formulaire d'édition d'une réservation
        Route::put('reservations/{id}', 'update')->middleware('auth')->name('reservations.update'); // Mettre à jour une réservation
        Route::post('reservations/{id}/return', 'returnBook')->middleware('auth')->name('reservations.return'); // Retourner un livre
        Route::delete('reservations/{id}', 'destroy')->middleware('auth')->name('reservations.destroy'); // Supprimer une réservation
    });


    // ----------------------- department -----------------------------//
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('department/list/page', 'departmentList')->middleware('auth')->name('department/list/page'); // department/list/page
        Route::get('department/add/page', 'indexDepartment')->middleware('auth')->name('department/add/page'); // page add department
        Route::get('department/edit/{department_id}', 'editDepartment'); // page add department
        Route::post('department/save', 'saveRecord')->middleware('auth')->name('department/save'); // department/save
        Route::post('department/update', 'updateRecord')->middleware('auth')->name('department/update'); // department/update
        Route::post('department/delete', 'deleteRecord')->middleware('auth')->name('department/delete'); // department/delete
        Route::get('get-data-list', 'getDataList')->name('get-data-list'); // get data list

    });

    // ----------------------- subject -----------------------------//
    Route::controller(SubjectController::class)->group(function () {
        Route::get('subject/list/page', 'subjectList')->middleware('auth')->name('subject/list/page'); // subject/list/page
        Route::get('subject/add/page', 'subjectAdd')->middleware('auth')->name('subject/add/page'); // subject/add/page
        Route::post('subject/save', 'saveRecord')->name('subject/save'); // subject/save
        Route::post('subject/update/{subject_id}', 'updateRecord')->name('subject/update'); // subject/update
        Route::post('subject/delete', 'deleteRecord')->name('subject/delete'); // subject/delete
        Route::get('subject/edit/{subject_id}', 'subjectEdit'); // subject/edit/page
    });

    // ----------------------- classe -----------------------------//
    Route::controller(ClassController::class)->group(function () {
        Route::get('class/list/page', 'classList')->middleware('auth')->name('class/list/page'); // class/list/page
        Route::get('class/grid', 'grid')->middleware('auth')->name('class/grid'); // class/grid
        Route::get('class/add/page', 'classAdd')->middleware('auth')->name('class/add/page'); // class/add/page
        Route::post('class/save', 'saveRecord')->name('class/save'); // class/save
        Route::get('class/edit/{id}', 'classEdit')->middleware('auth')->name('class/edit/page'); // class/edit/page
        Route::put('class/update/{id}', 'updateRecord')->name('class/update'); // class/update
        Route::post('class/delete', 'deleteRecord')->middleware('auth')->name('class/delete'); // class/delete
        Route::get('class/show/{id}', 'show')->middleware('auth')->name('class/show'); // class/show
    });

    // ----------------------- invoice -----------------------------//
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoice/list/page', 'invoiceList')->middleware('auth')->name('invoice/list/page'); // subjeinvoicect/list/page
        Route::get('invoice/paid/page', 'invoicePaid')->middleware('auth')->name('invoice/paid/page'); // invoice/paid/page
        Route::get('invoice/overdue/page', 'invoiceOverdue')->middleware('auth')->name('invoice/overdue/page'); // invoice/overdue/page
        Route::get('invoice/draft/page', 'invoiceDraft')->middleware('auth')->name('invoice/draft/page'); // invoice/draft/page
        Route::get('invoice/recurring/page', 'invoiceRecurring')->middleware('auth')->name('invoice/recurring/page'); // invoice/recurring/page
        Route::get('invoice/cancelled/page', 'invoiceCancelled')->middleware('auth')->name('invoice/cancelled/page'); // invoice/cancelled/page
        Route::get('invoice/grid/page', 'invoiceGrid')->middleware('auth')->name('invoice/grid/page'); // invoice/grid/page
        Route::get('invoice/add/page', 'invoiceAdd')->middleware('auth')->name('invoice/add/page'); // invoice/add/page
        Route::post('invoice/add/save', 'saveRecord')->name('invoice/add/save'); // invoice/add/save
        Route::post('invoice/update/save', 'updateRecord')->name('invoice/update/save'); // invoice/update/save
        Route::post('invoice/delete', 'deleteRecord')->name('invoice/delete'); // invoice/delete
        Route::get('invoice/edit/{invoice_id}', 'invoiceEdit')->middleware('auth')->name('invoice/edit/page'); // invoice/edit/page
        Route::get('invoice/view/{invoice_id}', 'invoiceView')->middleware('auth')->name('invoice/view/page'); // invoice/view/page
        Route::get('invoice/settings/page', 'invoiceSettings')->middleware('auth')->name('invoice/settings/page'); // invoice/settings/page
        Route::get('invoice/settings/tax/page', 'invoiceSettingsTax')->middleware('auth')->name('invoice/settings/tax/page'); // invoice/settings/tax/page
        Route::get('invoice/settings/bank/page', 'invoiceSettingsBank')->middleware('auth')->name('invoice/settings/bank/page'); // invoice/settings/bank/page
    });

    // ----------------------- accounts ----------------------------//
    Route::controller(AccountsController::class)->group(function () {
        Route::get('account/fees/collections/page', 'index')->middleware('auth')->name('account/fees/collections/page'); // account/fees/collections/page
        Route::get('add/fees/collection/page', 'addFeesCollection')->middleware('auth')->name('add/fees/collection/page'); // add/fees/collection
        Route::post('fees/collection/save', 'saveRecord')->middleware('auth')->name('fees/collection/save'); // fees/collection/save
    });
});