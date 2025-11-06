<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comercio;
use Illuminate\Http\Request;

class CategoriaClienteController extends Controller
{
    /**
     * Mostrar listado de categorías y comercios
     */
    public function index(Request $request)
    {
        // Obtener todas las categorías activas con conteo de comercios
        $categorias = Categoria::where('tb_categoria.NUM_ESTADO', 1)  
    ->withCount(['comercios' => function ($query) {
        $query->where('tb_comercio.NUM_ESTADO', 1);  
    }])
            ->orderBy('DSC_NOMBRE')
            ->get();

        $totalComercios = Comercio::where('NUM_ESTADO', 1)->count();

        $query = Comercio::with('categorias')
            ->where('NUM_ESTADO', 1);

        if ($request->filled('categoria')) {
            $query->whereHas('categorias', function ($q) use ($request) {
                $q->where('DSC_NOMBRE', $request->categoria);
            });
        }

        // Filtrar por búsqueda
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function ($q) use ($busqueda) {
                $q->where('DSC_COMERCIO', 'like', "%{$busqueda}%")
                    ->orWhere('DSC_DIRECCION', 'like', "%{$busqueda}%");
            });
        }

        // Filtrar por ubicación
        if ($request->filled('ubicacion')) {
            $query->where('DSC_DIRECCION', 'like', "%{$request->ubicacion}%");
        }

        // Ordenamiento
        switch ($request->get('orden', 'reciente')) {
            case 'nombre_asc':
                $query->orderBy('DSC_COMERCIO', 'asc');
                break;
            case 'nombre_desc':
                $query->orderBy('DSC_COMERCIO', 'desc');
                break;
            case 'reciente':
            default:
                $query->latest('FEC_CREACION');
                break;
        }

        // Paginar resultados
        $comercios = $query->paginate(9)->withQueryString();

        return view('cliente.categorias.index', compact('categorias', 'comercios', 'totalComercios'));
    }
}