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


/* Auth
 * 
 * /register
 * /login
*/
    
// for candidate
Route::post('/user/register', 'UserController@register');
Route::post('/user/login',    'UserController@login');

Route::middleware('auth:sanctum')->apiResource('users',    'UserAPIController');
// Route::apiResource('candidates',    'UserAPIController');

/* Profile
 * 
 * /account
 * /account/update
*/
