<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployerRequest;
use App\Http\Resources\EmployerResource;
use App\Http\Helpers\UploadImages;
use App\Http\Exceptions\Handler;
use Exception;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Psr7\Message;

class EmployerController extends Controller
{

    private $uploader;
  
    public function __construct()
    {
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
            $new_employer = $request->all();
            $new_employer['logo'] = $this->uploader->file_operations($request,'logo');
            $employer = Employer::create($new_employer);
            $employer->save();
            return new EmployerResource($employer);
        } catch (Exception $e) {
            // Handle other exceptions
            return response()->json(['message' => $e], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
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
        //
    }
}
