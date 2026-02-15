<?php

namespace App\Http\Controllers\Api; // must match the folder structure

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WorkerAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
                    ->where('role', 'worker')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid username or password'], 401);
        }

        if ($user->status === 'pending') {
            return response()->json(['message' => 'Your account is waiting for admin approval'], 403);
        }

        if ($user->status === 'deactivate') {
            return response()->json(['message' => 'Your account has been deactivated'], 403);
        }

        $token = $user->createToken('worker-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
