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
    public function login(UserLoginRequest $request)
    {
        $user      = User::where('email', $request->email)->where('role', 'candidate')->first();
        if ($user) {
            $userPass  = Hash::check($request->password, $user->password);
            $token = $user->createToken('token')->plainTextToken;
            $profile = Profile::where('user_id', $user->id)->first();

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
        $role = $request->input('role') ?? 'candidate';

        if ($request->realimage) {
            $image = $request->realimage;
            $image->move(public_path('images'), $image->getClientOriginalName());
        }

        $password = Hash::make($request->input('password'));
        $request->merge([
            'password' => $password,
            'role' => $role,
            'image' => $request->realimage ? $request->realimage->getClientOriginalName() : null
        ]);

        $user = User::create($request->all());

        $profile = Profile::create([
            'user_id' => $user->id,
            'summary' => 'Type here your experience',
            'experience' => 'Type here your experience',
            'resume'  => 'Type here your resume',
            'skills'  => 'Type here your skills',
            'phone'   => 'Type here your phone',
            'address' => 'Type here your address',
            'personal_website' => 'Type here your personal website'
        ]);

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
