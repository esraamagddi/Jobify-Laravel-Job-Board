<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function list()
    {
        $applications = auth()->user()->applications;
        return response()->json($applications);
    }

    public function change(Request $request)
    {
        $updated_application = DB::table('applications')
                           ->where('job_id', $request->get('job_id'))
                           ->where('user_id', auth()->user()->id)->limit(1)
                           ->update(['status' => $request->get('status')]);

        if ($updated_application)
            return response()->json([
                'Message' => 'Application status is updated Successefully',
            ], Response::HTTP_OK);

        return response()->json([
            'Message' => 'Error Check Your Data'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
