<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

<<<<<<< HEAD

Route::apiResource("admins", AdminController::class)->except(['store']);

Route::post('/admins', 'App\Http\Controllers\AdminController@register');

=======
Route::apiResource('employers',EmployerController::class);

Route::apiResource('posts',PostController::class);

Route::apiResource('categories', CategoryController::class);
>>>>>>> origin/employers
