<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerSlider;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\CategoriaClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\GaleriaProductoController;
use App\Http\Controllers\GaleriaComercioController;
use App\Http\Controllers\ProductoClienteController;
use App\Http\Controllers\DashboardController;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/*
|--------------------------------------------------------------------------
| Rutas Públicas - Directorio Comercial
|--------------------------------------------------------------------------
*/

Route::get('/', [DirectorioController::class, 'index'])->name('directorio.home');
Route::get('/directorio', [DirectorioController::class, 'index'])->name('directorio.index');

// Nueva ruta para búsqueda - DEBE IR ANTES de las rutas con parámetros
Route::get('/directorio/buscar', [DirectorioController::class, 'buscar'])->name('directorio.buscar');

// Rutas para categorías del cliente (PÚBLICAS)
Route::resource('categoriasCliente', CategoriaClienteController::class);

Route::get('/comercio/{id}', [CategoriaClienteController::class, 'show'])->name('comercio.show');

Route::get('/comercio/{comercio}/producto/{producto}', [ProductoClienteController::class, 'show'])->name('producto.show');
/*
|--------------------------------------------------------------------------
| Rutas de Administración
|--------------------------------------------------------------------------
*/

// Dashboard - requiere autenticación (ACTUALIZADA)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Rutas protegidas de administración
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('comercios', ComercioController::class);
    Route::resource('sliders', ControllerSlider::class);
    
    // Rutas de administración de categorías (protegidas)
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);

    // Rutas de Galería de Productos
    Route::prefix('productos/{producto}/galeria')->name('productos.galeria.')->group(function () {
        Route::get('/', [GaleriaProductoController::class, 'index'])->name('index');
        Route::post('/', [GaleriaProductoController::class, 'store'])->name('store');
        Route::post('/orden', [GaleriaProductoController::class, 'updateOrder'])->name('updateOrder');
        Route::delete('/{imagen}', [GaleriaProductoController::class, 'destroy'])->name('destroy');
    });

    // Rutas de Galería de Comercios
    Route::prefix('comercios/{comercio}/galeria')->name('comercios.galeria.')->group(function () {
        Route::get('/', [GaleriaComercioController::class, 'index'])->name('index');
        Route::post('/', [GaleriaComercioController::class, 'store'])->name('store');
        Route::post('/orden', [GaleriaComercioController::class, 'updateOrder'])->name('updateOrder');
        Route::delete('/{imagen}', [GaleriaComercioController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/directorio', [DirectorioController::class, 'index'])->name('directorio.index');

// Rutas de autenticación (login manual - ruta oculta)
require __DIR__.'/auth.php';