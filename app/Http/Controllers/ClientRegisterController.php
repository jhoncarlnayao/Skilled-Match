<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a 'users' table for clients
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientRegisterController extends Controller
{
    // Show the registration form
    public function showForm()
    {
        return view('create_account_user'); // Make sure this Blade exists
    }

    // Handle registration submission
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the client
        User::create([
    // 'name' => $request->first_name . ' ' . $request->last_name, // required for default Laravel user table
    'first_name' => $request->first_name,
    'middle_name' => $request->middle_name,
    'last_name' => $request->last_name,
    'username' => $request->username,
    'password' => Hash::make($request->password),
    'phone' => $request->phone,
    'email' => $request->email,
    'address' => $request->address,
    'role' => 'client',
    'status' => 'Active',
]);


        return redirect()->back()->with('success', 'Account created successfully. You can now log in.');
    }
}
