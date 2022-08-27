<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', '\App\Http\Controllers\Api\UserController@login');
Route::post('register', '\App\Http\Controllers\Api\UserController@register');

Route::group(['middleware' => 'auth:sanctum'], function () {

	// create appointment
	Route::post('create-appointment', '\App\Http\Controllers\Api\AppointmentController@create');
	Route::get('appointment-list', '\App\Http\Controllers\Api\AppointmentController@getAppointments');
});