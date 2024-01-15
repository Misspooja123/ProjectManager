<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProjectUserDataTable;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;

class AddProjectController extends Controller
{
    //
    public function index(ProjectUserDataTable $dataTable)
    {
        $users = User::all();

        return $dataTable->render('project_manager.add_project.add_project', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'user_id' => 'required|array|min:1',
        ]);

        // Create the project
        $project = Project::create([
            'project_name' => $validatedData['project_name'],
        ]);

        // Attach users to the project
        foreach ($validatedData['user_id'] as $userId) {
            ProjectUser::create([
                'project_id' => $project->id,
                'user_id' => $userId,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function cordinator(Request $request, $id)
    {
        try {
            $record = ProjectUser::find($id);
            if ($record) {
                $record->roles = '1';
                $record->save();
                return response()->json(['success' => true, 'message' => 'cordinator.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function employee(Request $request, $id)
    {
        try {
            $record = ProjectUser::find($id);
            if ($record) {
                $record->roles = '2';
                $record->save();
                return response()->json(['success' => true, 'message' => 'employee.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
