<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class ProfileController extends Controller
{
    //
    public function index()
    {
        return view('project_manager.profile.profile');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {

            if (!Hash::check($request->old_password, auth()->guard('admin')->user()->password)) {
                return response()->json(['error' => 'Current password do not match']);
            }
            //Update new password
            Admin::whereId(auth()->guard('admin')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return response()->json(['success' => true, 'message' => 'Password updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something want wrong.'], 404);
        }
    }
}
