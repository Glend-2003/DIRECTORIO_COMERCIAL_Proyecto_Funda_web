<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comercio;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Slider;

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

        return view('cliente.categorias.index', compact(
            'categorias',
            'comercios',
            'totalComercios'
        ));
    }

    // Mostrar detalles de un comercio específico
    public function show($id)
    {
        try {
            $comercio = Comercio::with(['categorias', 'galeria' => function ($query) {
                $query->where('NUM_ESTADO', 1)->orderBy('DSC_ORDEN');
            }, 'productos' => function ($query) {
                $query->where('NUM_ESTADO', 1);
            }])
                ->where('NUM_ESTADO', 1)
                ->findOrFail($id);

            return view('cliente.comercio.show', compact('comercio'));
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')
                ->with('error', 'Comercio no encontrado');
        }
    }
}
