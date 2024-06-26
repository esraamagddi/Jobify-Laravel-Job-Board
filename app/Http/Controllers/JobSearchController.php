<?php

namespace App\Http\Controllers;
use App\Http\Exceptions\Handler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class JobSearchController extends Controller
{

    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;

    }

    public function search(Request $request)
    {
    try {
        $rules = [
            'keywords' => 'nullable|string',
            'location' => 'nullable|string',
            'category' => 'nullable|exists:categories,id',
            'experience_level' => 'nullable|string',
            'salary_range' => 'nullable|string',
           // 'work_type' => 'nullable|in:offline,remote,hybrid',
           'work_type' => 'nullable|array',
           'work_type.*' => 'in:offline,remote,hybrid',
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
                  ->orWhere('skills', 'like', '%' . $request->keywords . '%')
                  ->orWhere('responsibilities', 'like', '%' . $request->keywords . '%')
                  ->orWhere('qualifications', 'like', '%' . $request->keywords . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }
        if ($request->filled('skills')) {
            $query->Where('skills', 'like', '%' . $request->skills . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('salary_range')) {
            $query->whereBetween('salary_range', [0,  $request->salary_range]);
        }

        if ($request->filled('work_type')) {
            $query->whereIn('work_type', $request->work_type);
        }


        if ($request->filled('deadline')) {
            $query->whereDate('deadline', $request->deadline);
        }

        if ($request->filled('employer_name')) {
            $query->whereHas('employer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->employer_name . '%');
           });
         }


         $jobs = $query->with(['category', 'employer'])->paginate(4);


        return response()->json($jobs);

    } catch (Exception $e) {
        return $this->handler->render($request, $e);
    }
    }

    public function getLocations(Request $request)
{
try {
    $locations = Post::select('location')->distinct()->get();
    return response()->json($locations);
} catch (Exception $e) {
    return $this->handler->render($request, $e);
}
}

public function getCategories(Request $request)
{
try {
    $categories = Category::all();
    return response()->json($categories);
} catch (Exception $e) {
    return $this->handler->render($request, $e);
}
}

public function getRecentPosts(Request $request)
{
    try {

        $recentPosts = Post::orderBy('created_at', 'desc')->with(['category', 'employer'])->take(4)->get();

        return response()->json($recentPosts);
    } catch (Exception $e) {
        return $this->handler->render($request, $e);


    }
}

}

?>
