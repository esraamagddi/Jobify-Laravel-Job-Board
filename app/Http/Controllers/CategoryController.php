<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResources;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json([
            'data' => Category::all(),
            'count' => Category::count()
        ]);

    }

    public function getPostsByCategory(){
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:50',
        ]);

        $user_id = Auth::id();
        $validatedData['user_id'] = $user_id;

        Gate::authorize('create', Category::class);
        $category = Category::create($validatedData);
        return new CategoryResources($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResources($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $validatedData = $request->validate([
                'name' => 'required|unique:categories|max:50',
            ]);

            Gate::authorize('update', $category);

            $category->update([
                'name' => $request->input('name'),
            ]);

            return new CategoryResources($category);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
            Gate::authorize('delete', $category);

            $category->delete();
            return response()->json(['message' => 'Category deleted']);
    }
}
