<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\mediaController;
use App\Http\Controllers\MediaController as ControllersMediaController;
use App\Http\Controllers\ProfileController;
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
Route::get('/profile/{profile}',[ProfileController::class,'show']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('register',[AuthController::class,'register']);
    Route::patch('edit/user/{user}',[AuthController::class,'update']);
    Route::delete('user/{user}',[AuthController::class,'destroy']);
    Route::resource('/profile',ProfileController::class)->only([
       'store' , 'destroy'
    ]);
    Route::get('/user/{user:uuid}',[ProfileController::class,'myprofile']);
    Route::post('edit/profile/{profile}',[ProfileController::class,'update']);
    Route::post('visit/link/{link}',[ProfileController::class,'visitLink']);
    Route::post('views/link/{link}',[ProfileController::class,'getViews_link']);
    Route::post('visit/profile/{profile}',[ProfileController::class,'visitProfile']);
    Route::post('views/profile/{profile}',[ProfileController::class,'getViews_profile']);
    // Route::get('links/profile/{profile}',[ProfileController::class,'getLinks']);
    Route::get('profile/{profile}/link/{link}',[LinkController::class,'getLinks']);
    Route::delete('profile/{profile}/link/{link}',[LinkController::class,'DeleteLink']);
    Route::get('profile/{profile}/media/{media}',[MediaController::class,'getMedia']);
    Route::delete('profile/{profile}/media/{media}',[MediaController::class,'DeleteMedia']);
});

