<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    return "Oksssssssssssssss";
});


/* Auth
 * 
 * /register
 * /login
*/
Route::post('register', 'UserAPIController@register');
Route::post('login',    'UserAPIController@login');
 

/* Profile
 * 
 * /account
 * /account/update
*/
