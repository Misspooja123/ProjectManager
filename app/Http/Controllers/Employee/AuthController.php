<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    // public function loginindex()
    // {

    //     if (auth()->user()) {
    //         return redirect()->route('home.index');
    //     }

    //     return view('employee.login');
    // }
    public function loginindex()
    {

        if (Auth()->user()) {
            return redirect()->route('home.index');
        }
        return view('employee.login');
    }

    public function registerindex()
    {
        return view('employee.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        // Create and save the user
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->save();
        return response()->json(['message' => 'Account created successfully', 'redirect' => '/login']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if($request->rememberme===null){
            setcookie('email',$request->email,100);
            setcookie('password',$request->password,100);
         }
         else{
            setcookie('email',$request->email);
            setcookie('password',$request->password);

         }

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return response()->json(['message' => 'Login successful', 'redirect' => '/home']);
        }

        // Authentication failed
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth()->logout();
        return redirect('login');
    }
}
