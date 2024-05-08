<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Excpetions\CustomExceptionHandler;
use App\Http\Requests\StoreEmployerRequest;
use App\Http\Resources\EmployerResource;

class EmployerController extends Controller
{

private $handler;
/* public function __construct(){
    $handler = new CustomExceptionHandler();
} */

    /**
     * Display a listing of the resource.
     */

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
        try {
        $employer = Employer::create($request->all());
        $employer->save();
        return new EmployerResource($employer);
        } catch (\Exception $e) {
            return back()->with("error", $e->getMessage());
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
