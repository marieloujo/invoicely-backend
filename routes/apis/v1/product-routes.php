<?php

use App\Http\Controllers\APIs\v1\ProductController;
use App\Http\Controllers\APIs\v1\SupplyController;
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

    Route::apiResource("products", ProductController::class)->names("products");

    Route::get("products/{product}/prices", [ProductController::class, "prices"])->name("prices");

    Route::apiResource("supplies", SupplyController::class)
        ->only(['index', 'store', 'show'])
        ->names("products");

});
