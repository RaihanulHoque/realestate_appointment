<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppointmentController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);  
    
    //Contact CRUD
    Route::get('/contacts', [ContactController::class, 'index']);  
    Route::post('/contacts', [ContactController::class, 'store']);  
    Route::get('/contact/{id}', [ContactController::class, 'show']);  
    Route::put('/contact/{id}', [ContactController::class, 'update']);  
    Route::delete('/contact/{id}', [ContactController::class, 'destroy']);  
        
    //Apointment CRUD
    Route::get('/appointments', [AppointmentController::class, 'index']);  
    Route::post('/appointments', [AppointmentController::class, 'store']);  
    Route::get('/appointment/{id}', [AppointmentController::class, 'show']);  
    Route::put('/appointment/{id}', [AppointmentController::class, 'update']);  
    Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy']);
});
