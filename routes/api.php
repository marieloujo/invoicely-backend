<?php

use App\Helpers\RouteLoader;
use App\Http\Controllers\APIs\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

RouteLoader::loadRoutesFrom(base_path('routes/apis'));
