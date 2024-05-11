<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    return "Oksssssssssssssss";
});


// Manage their profile information and applications.// cancel apply

  
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
*/
