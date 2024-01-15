<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProjectListDataTable;
use App\DataTables\AllProjectListDataTable;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //
    public function index()
    {
        return view('employee.project.index');
    }

    public function allproject(AllProjectListDataTable $dataTable)
    {
        return $dataTable->render('employee.project.allproject');
    }

    public function myproject(ProjectListDataTable $dataTable)
    {
        $user = Auth::user();
        return $dataTable->setUser($user)->render('employee.project.myproject');
    }
}
