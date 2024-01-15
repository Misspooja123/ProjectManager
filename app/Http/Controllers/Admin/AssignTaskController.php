<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\TaskDataTable;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Task;

class AssignTaskController extends Controller
{
    //
    public function index(TaskDataTable $dataTable)
    {
        $users = User::all();
        $projects = Project::all();

        return $dataTable->render('project_manager.assign_task.task', compact('users', 'projects'));
    }

    public function store(Request $request)
    {
        $emp = new Task();
        $emp->task_name = $request->input('task_name');
        $emp->project_id = $request->input('project_id');
        $emp->user_id = $request->input('user_id');
        $emp->startdate = $request->input('startdate');
        $emp->enddate = $request->input('enddate');
        $emp->roles = $request->input('roles');
        $emp->save();

        return response()->json(['message' => 'task added successfully']);
    }

    public function getUsersByProject($projectId)
    {
        $projectUsers = ProjectUser::where('project_id', $projectId)->get();
        $userIds = $projectUsers->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->get();
        return response()->json(['users' => $users]);
    }

    public function getRolesByProjectUser(Request $request)
    {
        $projectId = $request->get('project_id');
        $userId = $request->get('user_id');

        $projectUser = ProjectUser::where('project_id', $projectId)
            ->where('user_id', $userId)->first();
        $roles = $projectUser->roles;
        return response()->json(['roles' => $roles]);
    }
}
