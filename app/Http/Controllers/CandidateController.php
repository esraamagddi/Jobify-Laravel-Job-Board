<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateLoginRequest;
use App\Http\Requests\CandidateRequest;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class CandidateController extends Controller
{
    
    public function login(CandidateLoginRequest $request)
    {
        $candidate      = Candidate::where('email', $request->email)->first();
        $candidatePass  = Hash::check($request->password, $candidate->password);
        $token = $candidate->createToken('token')->plainTextToken;

        if ($candidate && $candidatePass) {
            return response()->json([
                'Message' => 'Login Success',
                'candidate' => $candidate,
                'Token' => $token
            ], Response::HTTP_OK);
        }

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function register(CandidateRequest $request)
    {

        $password = Hash::make($request->input('password'));
        $request->merge(['password' => $password]);
        $candidate = Candidate::create($request->all());
        $token = $candidate->createToken('token')->plainTextToken;

        if ($candidate)
            return response()->json([
                'Message' => 'Registered Successefully',
                'candidate' => $candidate,
                'Token' => $token
            ], Response::HTTP_OK);

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
