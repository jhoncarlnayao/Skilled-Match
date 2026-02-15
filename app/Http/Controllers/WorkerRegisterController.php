<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worker;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class WorkerRegisterController extends Controller
{
    // Show the registration form for web
    public function create()
    {
        $trades = Trade::all(); // get trades for dropdown
        return view('create_account_worker', compact('trades'));
    }

    // Handle form submission for web
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required',
            'trade_id' => 'required|exists:trades,id',
            'experience_years' => 'required|integer|min:0'
        ]);

        DB::transaction(function() use ($request){
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'worker',
                'status' => 'pending',
            ]);

          Worker::create([
    'user_id' => $user->id,
    'phone' => $request->phone,
    'trade_id' => $request->trade_id, // <-- use ID from picker
    'experience_years' => $request->experience_years
]);
        });

        return redirect()->back()->with('success', 'Registration successful. Please wait for admin approval.');
    }

    // Handle API registration for React Native
    public function apiRegister(Request $request)
    {
       $request->validate([
    'first_name' => 'required|string',
    'last_name' => 'nullable|string',
    'username' => 'required|string|unique:users',
    'email' => 'required|email|unique:users',
    'phone' => 'required|string',
    'trade_id' => 'required|exists:trades,id', // must match column
    'experience_years' => 'required|integer|min:0',
    'password' => 'required|string|min:6',
]);


        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'worker',
                'status' => 'pending',
            ]);

            // Create Worker
            Worker::create([
    'user_id' => $user->id,
    'phone' => $request->phone,
    'trade_id' => $request->trade_id, // <- correct column
    'experience_years' => $request->experience_years
]);


            DB::commit();

            // Generate API token using Sanctum
            $token = $user->createToken('worker-token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful',
                'token' => $token,
                'user' => $user
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
