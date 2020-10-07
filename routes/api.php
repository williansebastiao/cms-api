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

Route::group(['prefix' => 'administrator'], function (){
    Route::post('authenticate', [\App\Http\Controllers\Api\AdministratorController::class, 'authenticate']);
    //Route::post('email', 'Api\ForgotPasswordController@sendResetLinkEmail');
    //Route::post('reset', 'Api\ResetPasswordController@reset');
});

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::group(['prefix' => 'administrator'], function (){
        Route::get('me', [\App\Http\Controllers\Api\AdministratorController::class, 'me']);
        Route::get('findAll', [\App\Http\Controllers\Api\AdministratorController::class, 'findAll']);
        Route::get('findById/{id}', [\App\Http\Controllers\Api\AdministratorController::class, 'findById']);
        Route::post('store', [\App\Http\Controllers\Api\AdministratorController::class, 'store']);
        /*Route::put('update/{id}', 'Api\AdministratorController@update');
        Route::put('profile', 'Api\AdministratorController@profile');
        Route::post('avatar', 'Api\AdministratorController@avatar');
        Route::put('password', 'Api\AdministratorController@password');
        Route::delete('destroy/{id}', 'Api\AdministratorController@destroy');*/
    });
});
