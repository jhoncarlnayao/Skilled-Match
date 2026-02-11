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

        // Log the user in
        Auth::login($user);

        // Redirect by role
        if ($user->role === 'worker') {
            return redirect()->route('worker.dashboard'); // create this route
        } else {
            return redirect()->route('client.dashboard'); // create this route
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
