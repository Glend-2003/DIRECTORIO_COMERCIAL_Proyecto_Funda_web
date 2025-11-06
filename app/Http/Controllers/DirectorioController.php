<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Comercio;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    public function index()
    {
        // Obtener sliders activos para mostrar en el hero
        $sliders = Slider::where('NUM_ESTADO', 1)->get();

        $comerciosRecientes = Comercio::with('categorias')
            ->where('NUM_ESTADO', 1)
            ->latest('FEC_CREACION')
            ->take(3)
            ->get();
        
        return view('cliente.directorio', compact('sliders', 'comerciosRecientes'));
    }
}