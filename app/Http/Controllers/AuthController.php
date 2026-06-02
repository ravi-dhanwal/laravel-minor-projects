<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
            /** @var User $user */
            $user = Auth::user();

            if ($user->two_fa_is_active) {
                // Don't fully login yet — hold user in session, send OTP
                Auth::logout();
                $otp = (string) rand(100000, 999999);

                // Store temporarily in DB
                $user->update([
                    'two_fa_otp' => $otp,
                    'two_fa_expires_at' => Carbon::now()->addMinutes(10),
                ]);

                // Store user id in session for OTP step
                session(['2fa_pending_user' => $user->id]);

                Mail::to($user->email)->send(new OtpMail($otp));

                return redirect()->route('2fa.login.page');
            }

            return redirect()->route('dashboard');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    function showLoginOtp()
    {
        if (!session('2fa_pending_user')) {
            return redirect()->route('login');
        }
        return view('auth.2fa-verify');
    }

    function verifyLoginOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $userId = session('2fa_pending_user');

        if (!$userId) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);

        if ($user->two_fa_otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        if (Carbon::now()->gt($user->two_fa_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please login again.']);
        }

        // Clear OTP and fully login
        $user->update(['two_fa_otp' => null, 'two_fa_expires_at' => null]);
        session()->forget('2fa_pending_user');

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully');
    }

    public function sendOtp(Request $request)
    {
        $otp = (string) rand(100000, 999999);
        $user = Auth::user();
        $user->update([
            'two_fa_otp' => $otp,
            'two_fa_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        $mailres= Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP sent to ' . $user->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $user = Auth::user();

        if ($user->two_fa_otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        if (Carbon::now()->gt($user->two_fa_expires_at)) {
            return response()->json(['error' => 'OTP has expired. Please try again.'], 422);
        }

        $user->update([
            'two_fa_is_active' => true,
            'two_fa_otp' => null,
            'two_fa_expires_at' => null,
        ]);

        return response()->json(['message' => '2FA enabled successfully']);
    }

    public function disableTfa(Request $request)
    {
        Auth::user()->update([
            'two_fa_is_active' => false,
            'two_fa_otp' => null,
            'two_fa_expires_at' => null,
        ]);

        return response()->json(['message' => '2FA disabled']);
    }
}
