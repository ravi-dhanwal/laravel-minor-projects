<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    function showRegister(){
        return view('auth.register'); 
    }

    function showLoginPage(){
        return view('auth.login'); 
    }

    function dashboard(){
        return view('dashboard.index');
    }

    function usersList(){
        abort_unless(Auth::user()->can('view users'), 403);

        $users = User::orderBy('created_at', 'desc')->get();

        return view('dashboard.users-list', compact('users'));
    }

    function showUser(User $user){
        abort_unless(Auth::user()->can('view users'), 403);

        return view('dashboard.user-details', compact('user'));
    }

    function uploadProfilePhoto(Request $request){
        $request->validate([
            'photo' => 'required|string',
        ]);

        if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $request->photo)) {
            return response()->json(['error' => 'Invalid image format.'], 422);
        }

        $user = Auth::user();
        $imageData = base64_decode(substr($request->photo, strpos($request->photo, ',') + 1));

        $filename = 'user_' . $user->id . '.png';
        Storage::disk('public')->put('profile_photos/' . $filename, $imageData);

        $user->update(['profile_photo' => $filename]);

        return response()->json([
            'message' => 'Profile photo updated successfully.',
            'url' => Storage::url('profile_photos/' . $filename) . '?v=' . time(),
        ]);
    }

    function updatePassword(Request $request){
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 422);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return response()->json(['error' => 'New password must be different from the current password.'], 422);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['message' => 'Password updated successfully.']);
    }

    function toggleUserStatus(User $user){
        abort_unless(Auth::user()->can('manage users'), 403);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['user' => 'You cannot deactivate your own account.']);
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', $user->is_active ? 'User activated.' : 'User deactivated.');
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

        $user->assignRole($role);

        Auth::login($user);
        event(new UserRegistered($user));

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

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account has been deactivated. Please contact admin.']);
            }

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
