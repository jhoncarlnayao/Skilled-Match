<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worker;
use App\Models\Trade; // <-- import Trade
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class WorkerRegisterController extends Controller
{
    // Show the registration form
    public function create()
    {
        $trades = Trade::all(); // get trades for dropdown
        return view('create_account_worker', compact('trades'));
    }

    // Handle form submission
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'username'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'phone'=>'required',
            'trade_id'=>'required|exists:trades,id',
            'experience_years'=>'required|integer|min:0'
        ]);

        DB::transaction(function() use ($request){
            $user = User::create([
    'name' => $request->first_name . ' ' . $request->last_name,
    'username' => $request->username,   // <-- add this line
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'worker',
    'status' => 'pending',
]);


            Worker::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'trade_id' => $request->trade_id,
                'experience_years' => $request->experience_years
            ]);
        });

        return redirect()->back()->with('success', 'Registration successful. Please wait for admin approval.');
    }
}
