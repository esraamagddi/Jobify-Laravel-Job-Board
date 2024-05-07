<?php

namespace App\Http\Controllers;

use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CandidateResource::collection(Candidate::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        return new CandidateResource($candidate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
}
