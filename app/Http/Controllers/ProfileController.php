<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
  
    /**
     * Store profile for candidate
     */
    public function store(Request $request)
    {
        $profile = DB::table('profiles')
                            ->insert(array_merge($request->all(), 
                                                    ['user_id' => auth()->user()->id, 
                                                     'created_at' => now(),
                                                     'updated_at' => now()]));

        if ($profile)
            return response()->json([
                'Message' => 'Profile data is added Successefully'
            ], Response::HTTP_OK);

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return Profile::where('user_id',auth()->user()->id)->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $profile)
    {
        $profile = DB::table('profiles')->where('user_id', '=', auth()->user()->id)
                            ->update(array_merge($request->all(), ['updated_at' => now()]));

        if ($profile)
            return response()->json([
                'Message' => 'Profile data is updated Successefully',
            ], Response::HTTP_OK);

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
