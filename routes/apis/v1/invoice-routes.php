<?php

use App\Http\Controllers\APIs\v1\FactureController;
use App\Http\Controllers\APIs\v1\StatisticController;
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

    Route::apiResource("invoices", FactureController::class)
        ->only(['index', 'store', 'show'])
        ->names("invoices");

    Route::put("invoices/{invoice}/mark-as-paid", [FactureController::class, 'markAsPaid']);

    Route::get('/statistics', StatisticController::class);

});
