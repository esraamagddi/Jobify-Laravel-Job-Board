<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('employers',EmployerController::class);

Route::apiResource('jobs',JobController::class);
