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
Route::post('/candidate/register', 'CandidateController@register');
Route::post('/candidate/login',    'CandidateController@login');

Route::middleware('auth:sanctum')->apiResource('candidates',    'CandidateAPIController');
// Route::apiResource('candidates',    'CandidateAPIController');

/* Profile
 * 
 * /account
 * /account/update
*/
