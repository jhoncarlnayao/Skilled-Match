<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login submission
public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('username', $request->username)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid username or password.');
    }

    // If worker is pending
    if ($user->role === 'worker' && $user->status === 'pending') {
        return back()->with('error', 'Your account is waiting for admin approval.');
    }
    
    if ($user->status === 'deactivate') {
    return back()->with('error', 'Your account has been deactivated by admin.');
}

    // ✅ Proper login
    Auth::login($user);

    // ✅ VERY IMPORTANT (prevents session issues)
    $request->session()->regenerate();

    // Redirect by role
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard'); 
    } elseif ($user->role === 'worker') {
        return redirect()->route('worker.dashboard'); 
    } else {
        return redirect()->route('client.client_dashboard'); 
    }
}



    // Logout
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}

}
