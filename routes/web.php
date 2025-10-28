<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para el recurso Comercio
//Route::resource('comercios', App\Http\Controllers\ComercioController::class);   
Route::get('/debug-comercios', function () {
    $comercios = \App\Models\Comercio::all();
    
    dd([
        'total' => $comercios->count(),
        'comercios' => $comercios->toArray()
    ]);
});