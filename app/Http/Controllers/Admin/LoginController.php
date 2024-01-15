<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {

      if (Auth::guard('admin')->user()) {
        return redirect()->route('admin.dashboard');
    }
      return view('project_manager.login');
    }

    public function login_check(Request $request)
    {

      if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
        return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
      } else {
        return redirect()->route('admin_login')->with('error', 'wrong credentials!');
      }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
