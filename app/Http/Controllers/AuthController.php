<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    function showRegister(){
        return view('auth.register'); 
    }

    function showLoginPage(){
        return view('auth.login'); 
    }

    function dashboard(){
        // if (!Auth::check()) {
        //     return redirect()->route('login-page');
        // }
        return view('dashboard.index');
    }

    function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:50|min:3',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);

        // Check if admin exists
        $adminExists = User::where('role', 'admin')->exists();
        $role = $adminExists ? 'user' : 'admin';

        $user = USER::CREATE([
            'name' => $request->name,
            'email' => $request->email,
            'password' => HASH::MAKE($request->password),
            'role' => $role,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    function login(Request $request){

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:6|',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
