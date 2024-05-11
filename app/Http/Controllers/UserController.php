<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    // for candidate
    public function login(UserLoginRequest $request)
    {
        $user      = User::where('email', $request->email)->where('role', 'candidate')->first();
        if ($user) {
            $userPass  = Hash::check($request->password, $user->password);
            $token = $user->createToken('token')->plainTextToken;
            $profile = Profile::where('user_id',$user->id)->first();

            if ($user && $userPass) {
                return response()->json([
                    'Message' => 'Login Success',
                    'user' => $user,
                    'Token' => $token,
                    'Profile' => $profile
                ], Response::HTTP_OK);
            }
        } 

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // for candidate
    public function register(UserRequest $request)
    {

        $password = Hash::make($request->input('password'));
        $request->merge(['password' => $password, 'role' => 'candidate']);
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
