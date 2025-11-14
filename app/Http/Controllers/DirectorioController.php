<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Comercio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DirectorioController extends Controller
{
 public function index()
    {
        // Obtener sliders activos
        $sliders = Slider::where('NUM_ESTADO', 1)->get();

        // Obtener comercios recientes (ajusta según tu lógica)
        $comerciosRecientes = Comercio::with('categorias')
            ->where('NUM_ESTADO', 1)
            ->latest('FEC_CREACION')
            ->take(6)
            ->get();

        // Obtener categorías populares (con más comercios)
        $categoriasPopulares = Categoria::where('tb_categoria.NUM_ESTADO', 1)
            ->withCount(['comercios' => function ($query) {
                $query->where('tb_comercio.NUM_ESTADO', 1);
            }])
            ->orderBy('comercios_count', 'desc')
            ->take(8)
            ->get();

        return view('cliente.directorio', compact(
            'sliders',
            'comerciosRecientes',
            'categoriasPopulares'
        ));
    }

    public function buscar(Request $request)
    {
        try {
            $termino = $request->get('q');

            if (!$termino || strlen($termino) < 2) {
                return response()->json([]);
            }

            $comercios = Comercio::with('categorias')
                ->where('NUM_ESTADO', 1)
                ->where(function ($query) use ($termino) {
                    $query->where('DSC_COMERCIO', 'LIKE', "%{$termino}%")
                        ->orWhere('DSC_DIRECCION', 'LIKE', "%{$termino}%")
                        ->orWhereHas('categorias', function ($q) use ($termino) {
                            $q->where('DSC_NOMBRE', 'LIKE', "%{$termino}%");
                        });
                })
                ->get();

            return response()->json($comercios);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}
