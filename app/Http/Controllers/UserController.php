<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function login(UserLoginRequest $request)
    {
        $user      = User::where('email', $request->email)->first();
        $userPass  = Hash::check($request->password, $user->password);
        $token = $user->createToken('token')->plainTextToken;

        if ($user && $userPass) {
            return response()->json([
                'Message' => 'Login Success',
                'user' => $user,
                'Token' => $token
            ], Response::HTTP_OK);
        }

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function register(UserRequest $request)
    {

        $password = Hash::make($request->input('password'));
        $request->merge(['password' => $password]);
        $user = User::create($request->all());
        $token = $user->createToken('token')->plainTextToken;

        if ($user)
            return response()->json([
                'Message' => 'Registered Successefully',
                'user' => $user,
                'Token' => $token
            ], Response::HTTP_OK);

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
