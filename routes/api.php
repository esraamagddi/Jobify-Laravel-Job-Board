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
use App\Http\Controllers\UserAPIController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    return "Oksssssssssssssss";
});




// for candidate
Route::post('/user/register', 'UserController@register');
Route::post('/user/login',    'UserController@login');
Route::middleware('auth:sanctum')->post('/candidate/application', 'ApplicationController@change');
Route::middleware('auth:sanctum')->get('/candidate/application', 'ApplicationController@list');

Route::middleware('auth:sanctum')->apiResource('users',    'UserAPIController');
Route::middleware('auth:sanctum')->apiResource('profiles',    'ProfileController');
// Route::apiResource('candidates',    'UserAPIController');

/* Profile
*
 * /account
 * /account/update
 *

*/

// ------------------------------------------------



Route::get('/all-users', [AdminController::class,'getAllUsers']);
Route::get('/all-posts', [PostController::class,'allposts']);
Route::get('/all-categories', [CategoryController::class,'index']);
Route::middleware('auth:sanctum')->get('/usersprofile', [AdminController::class,'candidatesWithProfiles']);
Route::middleware('auth:sanctum')->get('/allemployers', [AdminController::class,'allEmployers']);
Route::middleware('auth:sanctum')->get('/trashed-users', [AdminController::class,'trashed']);
Route::middleware('auth:sanctum')->patch('/users/{id}/activate', [AdminController::class, 'activate']);
Route::middleware('auth:sanctum')->delete('/users/{id}/deactivate', [AdminController::class, 'deactivate']);
Route::middleware('auth:sanctum')->put("/post-update/{id}", [AdminController::class,'updatePostStatus']);
Route::middleware('auth:sanctum')->apiResource("admins", AdminController::class)->except('getAllUsers','updatePostStatus');



// employers
Route::middleware('auth:sanctum')->apiResource('employers', EmployerController::class)->except(['index','show','store']);
Route::apiResource('employers',EmployerController::class, ['only' => ['index','show','store']]);

// posts
Route::middleware('auth:sanctum')->apiResource('posts', PostController::class)->except(['index','show']);
Route::resource('posts', PostController::class, ['only' => ['index', 'show']]);
Route::get('/allposts', [PostController::class,'getPosts']);
// categories
Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class)->except(['index','show']);
Route::apiResource('categories', CategoryController::class, ['only' => ['show']]);


//search
Route::get('/jobs/search', [JobSearchController::class, 'search']);
Route::get('/jobs/recent', [JobSearchController::class, 'getRecentPosts']);
Route::get('/locations', [JobSearchController::class, 'getLocations']);
Route::get('/categories', [JobSearchController::class, 'getCategories']);

Route::resource('applications', ApplicationController::class)->except(['update']);
Route::middleware('auth:sanctum')->resource('applications',ApplicationController::class,['only'=>['update']]);
Route::put('/update-status/{id}',[AdminController::class,'updatePostStatus']);

// login & logout

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);



