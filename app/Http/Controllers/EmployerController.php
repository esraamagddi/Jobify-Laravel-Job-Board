<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\Handler;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Resources\EmployerResource;
use App\Http\Helpers\UploadImages;
use App\Http\Requests\StoreEmployerRequest;
use App\Models\User;
use Exception;

class EmployerController extends Controller
{

    private $uploader;
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
        $this->uploader = new UploadImages();
    }
    public function index()
    {
        $employers = Employer::paginate(10);
        return EmployerResource::collection($employers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerRequest $request)
    {
        try{
            $user_data = $request->only(['name', 'email', 'password', 'role']);
            $user_data['profile_photo_path'] = $this->uploader->file_operations($request);
            $user = User::create($user_data);
            $user->save();
            //dd($user);
            $employer_data = $request->only(['industry', 'branches', 'branding_elements']);
            $employer_data['user_id'] = $user->id; 
            $employer = Employer::create($employer_data);
            $employer->save();
            return new EmployerResource($employer);
        } catch (Exception $e) {
            return $this->handler->render($request, $e);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request,Employer $employer)
    {
            return new EmployerResource($employer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employer $employer)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        $employer->delete();
        return response()->json(["message" => 'employer deleted successfully']);
    }
}
