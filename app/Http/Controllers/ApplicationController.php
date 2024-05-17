<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use Illuminate\Support\Facades\Validator;
use App\Events\AppNotificationEvent;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ApplicationController extends Controller implements HasMiddleware
{
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
            'resume' => 'required|file|mimes:pdf',
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
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $application = Application::find($id);

        if ($application == null) {
            return response()->json(["error" => "Application not found"], 404);
        }

        $application->update([
            'status' => $request->status,
        ]);
        event(new AppNotificationEvent('New application created: ' . $application->id));

        return new ApplicationResource($application);
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
