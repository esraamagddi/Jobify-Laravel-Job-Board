<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSearchController;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');


Route::apiResource("admins", AdminController::class)->except(['store']);

Route::post('/admins', 'App\Http\Controllers\AdminController@register');


Route::apiResource("admins", AdminController::class);
Route::apiResource('employers',EmployerController::class);
Route::apiResource('posts',PostController::class);
Route::apiResource('categories', CategoryController::class);
Route::get('/jobs/search', [JobSearchController::class, 'search']);
  //   ->middleware('auth:sanctum');
Route::get('/locations', [JobSearchController::class, 'getLocations']);
Route::get('/categories', [JobSearchController::class, 'getCategories']);
Route::resource('applications', ApplicationController::class);


// login & logout

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);



