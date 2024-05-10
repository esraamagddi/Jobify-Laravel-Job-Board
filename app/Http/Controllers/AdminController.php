<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return AdminResource::collection(User::paginate(5));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        // Create a new Admin instance
        $admin = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), 
        ]);

        return response()->json(['message' => 'Admin created successfully', 'admin' => $admin], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::findOrFail($id);
        
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);
    
        $admin = User::findOrFail($id);
    
        $admin->name = $validatedData['name'];
        $admin->email = $validatedData['email'];
    
        if ($request->has('password')) {
            $admin->password = bcrypt($validatedData['password']);
        }
    
        $admin->save();
    
        return response()->json(['message' => 'Admin updated successfully', 'admin' => new AdminResource($admin)]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }
}
