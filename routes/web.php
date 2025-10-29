<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerSlider;

use App\Http\Controllers\ComercioController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $totalComercios = \App\Models\Comercio::where('NUM_ESTADO', 1)->count();
    $comerciosRecientes = \App\Models\Comercio::where('NUM_ESTADO', 1)
                                            ->latest()
                                            ->take(5)
                                            ->get();
    return view('admin.dashboard', compact('totalComercios', 'comerciosRecientes'));
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('comercios', ComercioController::class);
    Route::resource('sliders', ControllerSlider::class);
});

require __DIR__.'/auth.php';




