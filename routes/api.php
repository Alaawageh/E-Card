<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProfileController;
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

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::post('register',[AuthController::class,'register']);
Route::get('/profile/{profile}',[ProfileController::class,'show']);
Route::middleware('auth:sanctum')->group(function() {
    Route::get('auth/profile/{profile}',[ProfileController::class,'index']);
    Route::post('/profile',[ProfileController::class,'store']);
    Route::post('profile/{profile}',[ProfileController::class,'update']);
    Route::post('views/{link}',[ProfileController::class,'counter']);
});

