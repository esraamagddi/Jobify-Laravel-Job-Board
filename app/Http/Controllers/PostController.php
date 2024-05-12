<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $handler;
    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }
    public function index()
    {
        $posts = Post::paginate(10);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try {
            Gate::authorize('create', Post::class);
            $post_data = $request->all();   
            $post_data['user_id'] = Auth::user()->id;
            $post = Post::create($post_data);
            return new PostResource($post);
        } catch (\Exception $e) {
            return $this->handler->render($request, $e);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        try {

            Gate::authorize('update', $post);
            $request_params = $request->all();
            $post->title =  $request_params['title'] ?? $post->title;
            $post->description = $request_params['description'] ?? $post->description;
            $post->category_id = $request_params['category_id'] ?? $post->category_id;
            $post->work_type = $request_params['work_type'] ?? $post->work_type;
            $post->deadline = $request_params['deadline'] ?? $post->deadline;
            $post->location = $request_params['location'] ?? $post->location;
            $post->qualifications = $request_params['qualifications'] ?? $post->qualifications;
            $post->skills = $request_params['skills'] ?? $post->skills;
            $post->salary_range = $request_params['salary_range'] ?? $post->salary_range;
            $post->responsibilities = $request_params['responsibilities'] ?? $post->responsibilities;
            $post->update();
            return new PostResource($post);
        } catch (\Exception $e) {
            return $this->handler->render($request, $e);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        try {
        Gate::authorize('delete', $post);
        $post->delete();
        return response()->json(['message' => 'post deleted successfully'], 204);
        } catch (\Exception $e) {
            return $this->handler->render($request, $e);
        }
    }
}
