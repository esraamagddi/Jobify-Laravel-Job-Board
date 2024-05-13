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

// employers
Route::middleware('auth:sanctum')->apiResource('employers', EmployerController::class)->except(['index','show','store']);
Route::apiResource('employers',EmployerController::class, ['only' => ['index','show','store']]);

// posts
Route::middleware('auth:sanctum')->apiResource('posts', PostController::class)->except(['index','show']);
Route::resource('posts', PostController::class, ['only' => ['index', 'show']]);

// categories
Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class)->except(['index','show']);
Route::apiResource('categories', CategoryController::class, ['only' => ['index','show']]);

Route::get('/jobs/search', [JobSearchController::class, 'search']);
  //   ->middleware('auth:sanctum');
Route::get('/locations', [JobSearchController::class, 'getLocations']);
Route::get('/categories', [JobSearchController::class, 'getCategories']);
Route::resource('applications', ApplicationController::class)->except(['update']);
Route::middleware('auth:sanctum')->resource('applications',ApplicationController::class,['only'=>['update']]);
Route::put('/update-status',[AdminController::class,'updatePostStatus']);

// login & logout

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);



