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
//     public function store(Request $request)
//     {
//         $request->validate([
//             'first_name' => 'required',
//             'last_name' => 'required',
//             'username' => 'required|unique:users',
//             'email' => 'required|email|unique:users',
//             'password' => 'required|min:6',
//             'phone' => 'required',
//             'trade_id' => 'required|exists:trades,id',
//             'experience_years' => 'required|integer|min:0'
//         ]);

//         DB::transaction(function() use ($request){
//            $user = User::create([
//     'first_name' => $request->first_name,
//     'middle_name' => null,
//     'last_name' => $request->last_name,
//     'username' => $request->username,
//     'email' => $request->email,
//     'password' => Hash::make($request->password),
//     'role' => 'worker',
//     'status' => 'pending',
// ]);


//           Worker::create([
//     'user_id' => $user->id,
//     'phone' => $request->phone,
//     'trade_id' => $request->trade_id, // <-- use ID from picker
//     'experience_years' => $request->experience_years
// ]);
//         });

//         return redirect()->back()->with('success', 'Registration successful. Please wait for admin approval.');
//     }

public function store(Request $request)
    {
        $request->validate([
    'first_name' => 'required|string|max:255',
    'middle_name' => 'nullable|string|max:255',
    'last_name' => 'required|string|max:255',
    'birthdate' => 'nullable|date',

    'username' => 'required|string|unique:users',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6|confirmed',

    'phone' => 'required|string|max:20',
    'address' => 'nullable|string|max:255',
    'city' => 'nullable|string|max:100',
    'postal_code' => 'nullable|string|max:20',

    'trade_id' => 'required|exists:trades,id',
    'experience_years' => 'required|integer|min:0',

    'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
]);

        DB::transaction(function () use ($request) {

            // Handle profile picture upload
            $profilePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePath = $request->file('profile_picture')
                    ->store('profile_pictures', 'public');
            }

       
           $user = User::create([
    'first_name' => $request->first_name,
    'middle_name' => $request->middle_name,
    'last_name' => $request->last_name,
    'birthdate' => $request->birthdate,
    'username' => $request->username,
    'email' => $request->email,
    'phone' => $request->phone,
    'address' => $request->address,
    'city' => $request->city,
    'postal_code' => $request->postal_code,

    'profile_picture' => $profilePath,

    'password' => Hash::make($request->password),
    'role' => 'worker',
    'status' => 'pending',
]);

            // Create Worker
            Worker::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'trade_id' => $request->trade_id,
                'experience_years' => $request->experience_years
            ]);
        });

        return redirect()->back()
            ->with('success', 'Registration successful. Please wait for admin approval.');
    }


    // Handle API registration for React Native
public function apiRegister(Request $request)
{
    // Validate input
    $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'birthdate' => 'nullable|date',
        'username' => 'required|string|unique:users',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'trade_id' => 'required|exists:trades,id',
        'experience_years' => 'required|integer|min:0',
        'password' => 'required|string|min:6|confirmed',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // Handle profile picture upload
        $profilePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePath = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        }

        // Create User
        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birthdate' => $request->birthdate,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'profile_picture' => $profilePath,
            'password' => Hash::make($request->password),
            'role' => 'worker',
            'status' => 'pending',
        ]);

        // Create Worker
        Worker::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'trade_id' => $request->trade_id,
            'experience_years' => $request->experience_years,
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
