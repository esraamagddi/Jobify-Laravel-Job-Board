<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\Handler;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Events\AppNotificationEvent;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller implements HasMiddleware
{

    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }
    public static function middleware(): array
    {
        return [
            'auth:sanctum',
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::paginate(10);

        return ApplicationResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'resume' => 'required|file|mimes:pdf|max:2048',
            'contact_details' => 'nullable|string',
            'app_email' => 'required|email',
            'app_phone' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file('resume');
        $path = $file->store('resumes', 'public');

        $application = Application::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'resume' => $path,
            'contact_details' => $request->contact_details,
            'app_email' => $request->app_email,
            'app_phone' => $request->app_phone,
        ]);

        event(new AppNotificationEvent('New application created: ' . $application->id));

        return new ApplicationResource($application);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $application = Application::find($id);

        if ($application == null) {

            return  response()->json([
                "error" => "application not found"
            ], 404);
        }

        return new ApplicationResource($application);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        try{
            $validator = Validator::make($request->all(), [
                "status" => "required|in:accepted,rejected",
            ]);
            if ($validator->fails()) {
                return response()->json(['message'=>'Validation failed','data' => $validator->errors()], 422);
            }
    

           //dd(Auth::user()->role !== 'employer' || Auth::user()->id !== $application->user_id);
        if(Auth::user()->role !== 'employer' || Auth::user()->id !== $application->user_id)
        {
             throw new AuthorizationException('Unauthorized');
        }
            $application->update([
                'status' => $request->status,
            ]);
    
            return new ApplicationResource($application);
        }catch (\Exception $e){
            return $this->handler->render($request,$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::find($id);

        if ($application == null) {
            return response()->json(["error" => "application not found"], 404);
        }

        $filePath = $application->resume;


        $application->delete();

        if ($filePath && file_exists(public_path('storage/' . $filePath))) {
            unlink(public_path('storage/' . $filePath));
        }

        return response()->json(["message" => "application deleted successfully"], 200);
    }
}
