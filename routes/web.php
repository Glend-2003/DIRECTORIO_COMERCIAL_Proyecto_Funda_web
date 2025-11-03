<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\GaleriaProductoController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\CategoriaClienteController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTAS PÚBLICAS (Sin autenticación)
// ==========================================

// Página principal del directorio (público)
Route::get('/', [DirectorioController::class, 'index'])->name('directorio.index');

// Listado de categorías y comercios para clientes (público)
Route::get('/categoriasCli', [CategoriaClienteController::class, 'index'])->name('categorias.cliente');

// Dashboard (requiere autenticación)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// RUTAS DEL PERFIL (Requieren autenticación)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// RUTAS DE ADMINISTRACIÓN (Requieren autenticación)
// ==========================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Rutas de Categorías (CRUD completo)
    Route::resource('categorias', CategoriaController::class);
    
    // Rutas de Comercios (CRUD completo)
    Route::resource('comercios', ComercioController::class);
    
    // Rutas de Productos (CRUD completo)
    Route::resource('productos', ProductoController::class);
    
    // Rutas de Sliders (CRUD completo)
    Route::resource('sliders', SliderController::class);
    
    // Rutas de Galería de Productos (anidadas)
    Route::prefix('productos/{producto}/galeria')->name('productos.galeria.')->group(function () {
        Route::get('/', [GaleriaProductoController::class, 'index'])->name('index');
        Route::post('/', [GaleriaProductoController::class, 'store'])->name('store');
        Route::post('/orden', [GaleriaProductoController::class, 'updateOrder'])->name('updateOrder');
        Route::delete('/{imagen}', [GaleriaProductoController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';