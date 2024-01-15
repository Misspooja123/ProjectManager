<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AddEmployeeDataTable;
use App\Models\User;
use App\Http\Requests\AddEmployeeRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewEmployeeNotification;

class AddEmployeeController extends Controller
{
    //
    public function index(AddEmployeeDataTable $dataTable)
    {
        return $dataTable->render('project_manager.add_employee.index');
    }
    public function store(AddEmployeeRequest $request)
    {
        $emp = new User();
        $emp->name = $request->input('name');
        $emp->email = $request->input('email');
        $emp->password = $request->input('password');
        $emp->mobile_no = $request->input('mobile_no');
        $emp->address = $request->input('address');
        $emp->save();

        Mail::to($emp->email)->send(new NewEmployeeNotification($emp));
        return response()->json(['message' => 'employee added successfully']);
    }
    public function destroy($id)
    {
        $emp = User::find($id);
        if ($emp != null) {
            $emp->delete();
            return response()->json(['message' => 'Employee deleted successfully']);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }

    public function edit($id)
    {
        try {
            $emp = User::find($id);
            return response()->json($emp);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $emp = User::find($id);
        if (!$emp) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
        $emp->mobile_no = $request->input('mobile_no');
        $emp->address = $request->input('address');
        $emp->save();
        return response()->json(['success' => true, 'message' => 'Update successful']);
    }


    public function validateuseremail(Request $request)
    {
        $user = User::where('email', $request->email)->first('email');
        if ($user) {
            $return =  false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit;
    }
    public function validateusermobile(Request $request)
    {
        $user = User::where('mobile_no', $request->mobile_no)->first('mobile_no');
        if ($user) {
            $return =  false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit;
    }
}
