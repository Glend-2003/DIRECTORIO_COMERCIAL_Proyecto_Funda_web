<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerSlider;

use App\Http\Controllers\ComercioController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $totalComercios = \App\Models\Comercio::count();
    $comerciosRecientes = \App\Models\Comercio::latest()->take(5)->get();
    return view('admin.dashboard', compact('totalComercios', 'comerciosRecientes'));
})->name('dashboard');

Route::resource('comercios', ComercioController::class);

Route::resource('sliders', ControllerSlider::class);
