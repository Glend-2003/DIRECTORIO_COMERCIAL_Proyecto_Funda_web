<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ControllerSlider;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DirectorioController;

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\GaleriaProductoController;
/*
|--------------------------------------------------------------------------
| Rutas Públicas - Directorio Comercial
|--------------------------------------------------------------------------
*/

// Página principal - Directorio Comercial (usando el controlador)
Route::get('/', [DirectorioController::class, 'index'])->name('directorio.home');
Route::get('/directorio', [DirectorioController::class, 'index'])->name('directorio.index');

/*
|--------------------------------------------------------------------------
| Rutas de Administración
|--------------------------------------------------------------------------
*/

// Dashboard - requiere autenticación
Route::get('/dashboard', function () {
    $totalComercios = \App\Models\Comercio::where('NUM_ESTADO', 1)->count();
    $comerciosRecientes = \App\Models\Comercio::where('NUM_ESTADO', 1)
        ->latest()
        ->take(5)
        ->get();
    return view('admin.dashboard', compact('totalComercios', 'comerciosRecientes'));
})->middleware('auth')->name('dashboard');

// Rutas protegidas de administración
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('comercios', ComercioController::class);
    Route::resource('sliders', ControllerSlider::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);

     // Rutas de Galería de Productos
    Route::prefix('productos/{producto}/galeria')->name('productos.galeria.')->group(function () {
        Route::get('/', [GaleriaProductoController::class, 'index'])->name('index');
        Route::post('/', [GaleriaProductoController::class, 'store'])->name('store');
        Route::post('/orden', [GaleriaProductoController::class, 'updateOrder'])->name('updateOrder');
        Route::delete('/{imagen}', [GaleriaProductoController::class, 'destroy'])->name('destroy');
    });
});

// Rutas de autenticación (login manual - ruta oculta)
require __DIR__.'/auth.php';