<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => User::where('role', 'candidate')->paginate(5),
            'count' => User::where('role', 'candidate')->count()
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($request->has('password')) {
            $password = Hash::make($request->input('password'));
            $request->merge(['password' => $password]);
        }

        $updated = $user->update($request->except('_method'));

        if ($updated)
            return response()->json([
                'Message' => 'Updated Successefully',
                'candidate' => new UserResource($user),
            ], Response::HTTP_OK);

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
