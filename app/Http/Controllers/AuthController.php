<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{


public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
   
        $token = $user->createToken($request->email);
        
        return response()->json([
            'Message' => 'Login Success',
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
        ], 200);    
    }

    return response()->json(['error' => 'Unauthorized'], 401);
}

public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        if (Auth::guard('sanctum')->check()) {
            $request->user('sanctum')->tokens()->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);
    }

}


