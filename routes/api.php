<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\mediaController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PrimaryLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
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



Route::get('/profile/{profile}',[ProfileController::class,'show']);

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);

Route::middleware('auth:sanctum')->group(function() {

    Route::middleware('isAdmin')->group(function() {
        Route::resource('user',UserController::class)->only('index','store','destroy');
        Route::patch('user/{user}',[UserController::class,'update'])->withoutMiddleware('isAdmin');
        Route::get('/user/{user:uuid}',[UserController::class,'show'])->withoutMiddleware(['isAdmin']);

        Route::get('theme',[ThemeController::class,'index'])->withoutMiddleware(['isAdmin']);
        Route::get('theme/{theme}',[ThemeController::class,'show'])->withoutMiddleware(['isAdmin']);
        Route::resource('theme',ThemeController::class)->only('store','destroy');
        Route::post('theme/{theme}',[ThemeController::class,'update']);

        Route::get('P_link',[PrimaryLinkController::class,'index'])->withoutMiddleware(['isAdmin']);
        Route::post('P_link',[PrimaryLinkController::class,'store']);
        Route::post('P_link/{primaryLink}',[PrimaryLinkController::class,'update']);
        Route::delete('P_link/{primaryLink}',[PrimaryLinkController::class,'destroy']);
    });
    
    Route::prefix('profile')->group(function(){
        
        Route::post('/',[ProfileController::class,'store']);
        Route::post('/{profile}',[ProfileController::class,'update']);
        Route::delete('/{profile}/primary_link/{profilePrimaryLink}',[PrimaryLinkController::class,'DeletePrimaryLink']);
        // Route::post('/{profile}/primary_link/{profilePrimaryLink}',[PrimaryLinkController::class,'UpdatePrimaryLink']);
        // Route::post('/{profile}/primary_link',[PrimaryLinkController::class,'AddPrimaryLink']);
        Route::patch('/{profile}/primary_link/{profilePrimaryLink}/changeAvailable',[ProfileController::class,'changeAvailableP_Link']);
        Route::post('{profile}/visit',[ProfileController::class,'visitProfile']);
        Route::post('/{profile}/views',[ProfileController::class,'getViews_profile']);
        Route::post('/{profile}/primary_link/{profilePrimaryLink}/visit',[ProfileController::class,'visitPrimary']);
        Route::get('/{profile}/allLinks',[ProfileController::class,'get_All_links']); 

        Route::prefix('{profile}/link')->group(function () {
            Route::delete('/{link}',[LinkController::class,'DeleteLink']);
            Route::post('/',[LinkController::class,'AddLink']);
            Route::patch('/{link}/changeAvailable',[LinkController::class,'changeAvailable']);
            Route::post('/{link}/visit',[LinkController::class,'visitLink']);
            Route::post('/{link}/views',[LinkController::class,'getViews_link']);
        });
        
        Route::prefix('{profile}/section')->group(function() {
            Route::delete('/{section}',[SectionController::class,'DeleteSection']);
            Route::post('/',[SectionController::class,'AddSection']);
            Route::patch('/{section}/changeAvailable',[SectionController::class,'changeAvailable']);
        });
        
    });

    //verify email
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class,'verifyEmail'])->name('verification.verify');

    //forget & reset password
    Route::post('forgotPassword',[NewPasswordController::class,'forgotPassword'])->name('password.email');
    Route::post('password/reset',[NewPasswordController::class,'passwordReset'])->name('password.reset');

});

