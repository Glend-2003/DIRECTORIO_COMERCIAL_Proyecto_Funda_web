<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComercioController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $totalComercios = \App\Models\Comercio::where('NUM_ESTADO', 1)->count();
    $comerciosRecientes = \App\Models\Comercio::where('NUM_ESTADO', 1)
                                            ->latest()
                                            ->take(5)
                                            ->get();
    return view('admin.dashboard', compact('totalComercios', 'comerciosRecientes'));
})->name('dashboard');

Route::resource('comercios', ComercioController::class);
