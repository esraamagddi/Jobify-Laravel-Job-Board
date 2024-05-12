<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');



Route::post('/admin',[AdminController::class,'intex']);

Route::middleware('auth:sanctum')->apiResource("admins", AdminController::class)->except(['index']);

Route::apiResource('employers',EmployerController::class);
Route::apiResource('posts',PostController::class);
Route::apiResource('categories', CategoryController::class);
Route::get('/jobs/search', [JobSearchController::class, 'search']);
  //   ->middleware('auth:sanctum');
Route::get('/locations', [JobSearchController::class, 'getLocations']);
Route::get('/categories', [JobSearchController::class, 'getCategories']);
Route::resource('applications', ApplicationController::class);
Route::put('/update-status',[AdminController::class,'updatePostStatus']);

// login & logout

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);



