<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comercio;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Slider;

class DashboardController extends Controller
{
    public function index()
    {
        $totalComercios = Comercio::where('NUM_ESTADO', 1)->count();
        $totalProductos = Producto::where('NUM_ESTADO', 1)->count();
        $totalCategorias = Categoria::where('NUM_ESTADO', 1)->count();
        $totalSliders = Slider::where('NUM_ESTADO', 1)->count();
        
        $comerciosRecientes = Comercio::where('NUM_ESTADO', 1)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalComercios',
            'totalProductos', 
            'totalCategorias',
            'totalSliders',
            'comerciosRecientes'
        ));
    }
}
