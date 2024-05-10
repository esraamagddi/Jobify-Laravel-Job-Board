<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAPIController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware("auth:sanctum");
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $candidate)
    {
        return new UserResource($candidate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        return $user;
        // if ($request->has('password')) {
        //     $password = Hash::make($request->input('password'));
        //     $request->merge(['password' => $password]);
        // }

        // $updated = $candidate->update($request->validated);

        // if ($updated)
        //     return response()->json([
        //         'Message' => 'Updated Successefully',
        //         'candidate' => $candidate,
        //     ], Response::HTTP_OK);

        // return response()->json([
        //     'Message' => 'Error Check Your Data'
        // ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
