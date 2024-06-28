<?php

use App\Helpers\RouteLoader;
use App\Http\Controllers\APIs\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [AuthController::class, 'user'])->middleware('auth:api');

RouteLoader::loadRoutesFrom(base_path('routes/apis'));
