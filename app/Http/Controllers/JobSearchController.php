<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    public function search(Request $request)
    {
        $rules = [
            'keywords' => 'nullable|string',
            'location' => 'nullable|string',
            'category' => 'nullable|exists:categories,id',
            'experience_level' => 'nullable|string',
            'salary_range' => 'nullable|string',
            'work_type' => 'nullable|in:offline,remote,hybrid',
            'deadline' => 'nullable|date_format:Y-m-d',
            'employer_name' => 'nullable|string',
        ];


        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $query = Post::query();

        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keywords . '%')
                  ->orWhere('description', 'like', '%' . $request->keywords . '%')
                  ->orWhere('responsibilities', 'like', '%' . $request->keywords . '%')
                  ->orWhere('skills', 'like', '%' . $request->keywords . '%')
                  ->orWhere('qualifications', 'like', '%' . $request->keywords . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        if ($request->filled('salary_range')) {
            $salaryRange = explode('-', $request->salary_range);
            $query->whereBetween('salary_range', [trim($salaryRange[0]), trim($salaryRange[1])]);
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        if ($request->filled('deadline')) {
            $query->whereDate('deadline', '=', $request->deadline);
        }

        if ($request->filled('employer_name')) {
            $query->whereHas('employer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->employer_name . '%');
           });
         }


        $jobs = $query->with('category')->paginate(10);

        return response()->json($jobs);
    }

    public function getLocations()
{
    $locations = Job::select('location')->distinct()->get();
    return response()->json($locations);
}

public function getCategories()
{
    $categories = Category::all();
    return response()->json($categories);
}

}

?>
