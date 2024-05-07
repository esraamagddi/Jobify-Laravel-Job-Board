<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Job::query();

        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keywords . '%')
                  ->orWhere('description', 'like', '%' . $request->keywords . '%');
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
            $query->whereBetween('salary', [trim($salaryRange[0]), trim($salaryRange[1])]);
        }

        if ($request->filled('date_posted')) {
            $query->whereDate('created_at', '=', $request->date_posted);
        }

        if ($request->filled('employer_name')) {
            $query->whereHas('employer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->employer_name . '%');
            });
        }


        $jobs = $query->with('category')->paginate(10); // Paginate results

        return response()->json($jobs);
    }
}

?>
