<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register',[\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login',[\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('verify_otp',[\App\Http\Controllers\Api\AuthController::class,'verify_otp']);

Route::middleware(['auth:sanctum','check_user_role'])->post('upload_image',[\App\Http\Controllers\Api\User\ProfileController::class,'upload_image']);
Route::middleware(['auth:sanctum','check_user_role'])->post('locations',[\App\Http\Controllers\Api\User\LocationController::class,'locations']);
