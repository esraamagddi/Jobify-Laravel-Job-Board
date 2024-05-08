<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployerRequest;
use App\Http\Resources\EmployerResource;
use App\Http\Helpers\UploadImages;
use App\Http\Exceptions\Handler;
use Exception;

class EmployerController extends Controller
{

    private $uploader;
    /* public function __construct(){
        $handler = new CustomExceptionHandler();
    } */
    
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->uploader = new UploadImages();
    }  
    public function index()
    {
        $employers = Employer::all();
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
        }catch(Exception $e){
            throw $e; 
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
