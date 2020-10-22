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

Route::get('/', function(){
   return response()->json(['message' => 'API Stup :)']);
});

Route::group(['prefix' => 'administrator'], function (){
    Route::post('authenticate', [\App\Http\Controllers\Api\AdministratorController::class, 'authenticate']);
    Route::post('email', [\App\Http\Controllers\Api\ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('reset', [\App\Http\Controllers\Api\ResetPasswordController::class, 'reset']);
});

Route::group(['prefix' => 'client'], function (){
    Route::post('authenticate', [\App\Http\Controllers\Api\ClientController::class, 'authenticate']);
    Route::post('register', [\App\Http\Controllers\Api\ClientController::class, 'register']);
    Route::post('email', [\App\Http\Controllers\Api\ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('reset', [\App\Http\Controllers\Api\ResetPasswordController::class, 'reset']);
});

Route::group(['middleware' => ['jwt.verify']], function (){
    Route::group(['prefix' => 'administrator'], function (){
        Route::get('me', [\App\Http\Controllers\Api\AdministratorController::class, 'me']);
        Route::get('findAll', [\App\Http\Controllers\Api\AdministratorController::class, 'findAll']);
        Route::get('findById/{id}', [\App\Http\Controllers\Api\AdministratorController::class, 'findById']);
        Route::get('findAllClients', [\App\Http\Controllers\Api\AdministratorController::class, 'findAllClients']);
        Route::get('findClientById/{id}', [\App\Http\Controllers\Api\AdministratorController::class, 'findClientById']);
        Route::post('store', [\App\Http\Controllers\Api\AdministratorController::class, 'store']);
        Route::put('update/{id}', [\App\Http\Controllers\Api\AdministratorController::class, 'update']);
        Route::delete('destroy/{id}', [\App\Http\Controllers\Api\AdministratorController::class, 'destroy']);
        /*Route::put('profile', 'Api\AdministratorController@profile');
        Route::post('avatar', 'Api\AdministratorController@avatar');
        Route::put('password', 'Api\AdministratorController@password');*/
    });
    Route::group(['prefix' => 'client'], function (){
        Route::get('me', [\App\Http\Controllers\Api\ClientController::class, 'me']);
        Route::post('store', [\App\Http\Controllers\Api\ClientController::class, 'store']);
        Route::put('update/{id}', [\App\Http\Controllers\Api\ClientController::class, 'update']);
        Route::delete('destroy/{id}', [\App\Http\Controllers\Api\ClientController::class, 'destroy']);
        Route::post('logout', [\App\Http\Controllers\Api\ClientController::class, 'logout']);
        /*Route::put('profile', 'Api\AdministratorController@profile');
        Route::post('avatar', 'Api\AdministratorController@avatar');
        Route::put('password', 'Api\AdministratorController@password');*/
    });
    Route::group(['prefix' => 'permission'], function (){
        Route::get('findAll', [\App\Http\Controllers\Api\PermissionController::class, 'findAll']);
        Route::post('store', [\App\Http\Controllers\Api\PermissionController::class, 'store']);
        Route::put('update/{id}', [\App\Http\Controllers\Api\PermissionController::class, 'update']);
        Route::delete('destroy/{id}', [\App\Http\Controllers\Api\PermissionController::class, 'destroy']);
    });
});
