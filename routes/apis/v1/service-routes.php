<?php

use App\Http\Controllers\APIs\v1\ServiceController;
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
Route::middleware("auth:api")->group(function () {

    Route::apiResource("services", ServiceController::class)->names("services");
    
    Route::get("services/{service}/prices", [ServiceController::class, "prices"])->name("prices");

});
