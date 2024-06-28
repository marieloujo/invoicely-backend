<?php

use App\Models\Facture;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Facture $facture) {
    return view('welcome');
});

Route::get('/{facture}', function (Facture $facture) {
    return view('facture', compact('facture'));
});
