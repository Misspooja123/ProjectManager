<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\AuthController;
use App\Http\Controllers\Admin\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//user side route
Route::get('/login', [AuthController::class, 'loginindex']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerindex']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');

Route::middleware('auth')->namespace('App\Http\Controllers\Employee')->group(function () {
    // User routes here
    Route::get('/home', 'HomeController@home')->name('home.index');

    Route::get('/projectlist', 'ProjectController@index')->name('projectlist.index');
    Route::get('/allprojectlist', 'ProjectController@allproject')->name('all_projectlist');
    Route::get('/myprojectlist', 'ProjectController@myproject')->name('my_projectlist');

    Route::get('/tasklist', 'TaskController@index')->name('tasklist');
    Route::get('/othertask', 'TaskController@othertask')->name('other_task');
    Route::get('/mytask', 'TaskController@mytask')->name('my_task');

    Route::post('/mytask', 'TaskController@storeassigntask')->name('assigntask.store');
    Route::get('/mytask/{projectId}', 'TaskController@getUsersByProject')->name('getuser.byproject');
    Route::get('/get-roles-by-project-user', 'TaskController@getRolesByProjectUser')->name('getroles_byprojectuser');

    Route::post('/mytask/complete/{id}', 'TaskController@completetask')->name('task.complete');
    Route::post('/mytask/closed/{id}', 'TaskController@closedtask')->name('task.closed');
});


//Admin route
Route::get('/admin/login', [LoginController::class, 'login'])->name('admin_login');
Route::post('/admin/login', [LoginController::class, 'login_check'])->name('login_check');

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('logout', 'LoginController@logout');
        Route::get('dashboard', 'DashboardController@dashboard')->name('admin.dashboard');

        Route::get('addEmployee', 'AddEmployeeController@index')->name('add_employee.index');
        Route::post('addEmployee', 'AddEmployeeController@store')->name('add_employee.store');
        Route::delete('addEmployee/{id}', 'AddEmployeeController@destroy')->name('add_employee.destroy');
        Route::get('addEmployee/edit/{id}', 'AddEmployeeController@edit')->name('addEmployee.edit');
        Route::put('addEmployee/update/{id}', 'AddEmployeeController@update')->name('addEmployee.update');
        Route::get('validate-email', 'AddEmployeeController@validateuseremail')->name('email.validation');
        Route::get('validate-mobile', 'AddEmployeeController@validateusermobile')->name('mobile.validation');

        Route::get('addProject', 'AddProjectController@index')->name('add_project.index');
        Route::post('addProject', 'AddProjectController@store')->name('add_project.store');
        Route::post('addProject/cordinator/{id}', 'AddProjectController@cordinator')->name('project.cordinator');
        Route::post('addProject/employee/{id}', 'AddProjectController@employee')->name('project.employee');

        Route::get('task', 'AssignTaskController@index')->name('task.index');
        Route::post('task', 'AssignTaskController@store')->name('task.store');
        Route::get('task/{projectId}', 'AssignTaskController@getUsersByProject')->name('users.by-project');
        Route::get('get-roles-by-project-user', 'AssignTaskController@getRolesByProjectUser')->name('get.roles.by.project.user');

        Route::get('profile', 'ProfileController@index')->name('profile.index');
        Route::post('changePassword', 'ProfileController@index')->name('changepassword');

    });
});
