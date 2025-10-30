<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    public function index()
    {
        // Obtener sliders activos para mostrar en el hero
        $sliders = Slider::where('ESTADO', 1)->get();
        
        return view('cliente.directorio', compact('sliders'));
    }
}