<?php

use App\Http\Controllers\APIs\v1\Auth\AuthController;
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
Route::prefix("auth")->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::post("/login", "login")->name("login");

        Route::post("/logout", "logout")->name("logout")->middleware('auth:api');;

        Route::post("/refresh", "refreshToken")->name("refresh");
    });

});
