<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a 'users' table for clients
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientRegisterController extends Controller
{

    public function showForm()
    {
        return view('create_account_user');
    }


public function register(Request $request)
{
    // Validate inputs
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'password' => 'required|string|min:6|confirmed',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:users,email',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
        'birthdate' => 'nullable|date',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Handle profile picture upload
    $profileImagePath = null;
    if ($request->hasFile('profile_picture')) {
        $profileImagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
    }

    // Create the client
    User::create([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'city' => $request->city,
        'postal_code' => $request->postal_code,
        'birthdate' => $request->birthdate,
        'profile_picture' => $profileImagePath,
        'role' => 'client',
        'status' => 'Active',
    ]);

    return redirect()->back()->with('success', 'Account created successfully. You can now log in.');
}

}