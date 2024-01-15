<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AllTaskDataTable;
use App\DataTables\MyTaskDataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\Project;

class TaskController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        $projects = Project::all();
        $user = Auth::user();
        $tasksExist = Task::where('user_id', $user->id)
                  ->where('roles', '1')
                  ->exists();
        // dd($tasksExist);

        return view('employee.task.index', compact('users', 'projects', 'tasksExist'));
    }

    public function othertask(AllTaskDataTable $dataTable)
    {
        return $dataTable->render('employee.task.othertask');
    }

    public function mytask(MyTaskDataTable $dataTable)
    {
        $user = Auth::user();
        $users = User::all();
        $projects = Project::all();
        return $dataTable->setUser($user)->render('employee.task.mytask', compact('users', 'projects'));
    }

    public function completetask(Request $request, $id)
    {
        try {
            $record = Task::find($id);
            if ($record) {
                $record->status = '1';
                $record->save();
                return response()->json(['success' => true, 'message' => 'Complete task.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function closedtask(Request $request, $id)
    {
        try {
            $record = Task::find($id);
            if ($record) {
                $record->status = '2';
                $record->save();
                return response()->json(['success' => true, 'message' => 'Closed task.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
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
