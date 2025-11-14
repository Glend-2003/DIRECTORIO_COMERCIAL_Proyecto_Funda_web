<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\GaleriaComercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GaleriaComercioController extends Controller
{
    /**
     * Mostrar la galería de un comercio específico
     */
    public function index($comercioId)
    {
        try {
            $comercio = Comercio::with('galeria')->findOrFail($comercioId);
            $imagenesGaleria = $comercio->galeria;
            
            return view('admin.comercios.galeria.index', compact('comercio', 'imagenesGaleria'));
        } catch (\Exception $e) {
            return redirect()->route('comercios.index')
                ->with('error', 'Comercio no encontrado');
        }
    }

    /**
     * Subir múltiples imágenes a la galería
     */
    public function store(Request $request, $comercioId)
    {
        $validator = Validator::make($request->all(), [
            'imagenes.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'imagenes.*.image' => 'Todos los archivos deben ser imágenes',
            'imagenes.*.max' => 'Las imágenes no deben superar los 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('comercios.galeria.index', $comercioId)
                ->withErrors($validator)
                ->with('error', 'Error al subir las imágenes');
        }

        try {
            $comercio = Comercio::findOrFail($comercioId);
            
            // Contar imágenes actuales
            $cantidadActual = GaleriaComercio::where('ID_COMERCIO', $comercioId)
                ->where('NUM_ESTADO', 1)
                ->count();
            
            if ($request->hasFile('imagenes')) {
                $imagenes = $request->file('imagenes');
                $cantidadNuevas = count($imagenes);
                
                // Validar que no exceda 6 imágenes
                if (($cantidadActual + $cantidadNuevas) > 6) {
                    return redirect()->route('comercios.galeria.index', $comercioId)
                        ->with('error', 'No puedes subir más de 6 imágenes en total. Actualmente tienes ' . $cantidadActual);
                }
                
                // Obtener el último orden
                $ultimoOrden = GaleriaComercio::where('ID_COMERCIO', $comercioId)
                    ->max('DSC_ORDEN') ?? 0;
                
                foreach ($imagenes as $imagen) {
                    $ultimoOrden++;
                    
                    // Generar nombre único
                    $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                    
                    // Crear directorio si no existe
                    $rutaCarpeta = public_path('images/galeria_comercios');
                    if (!File::exists($rutaCarpeta)) {
                        File::makeDirectory($rutaCarpeta, 0755, true);
                    }
                    
                    // Mover imagen
                    $imagen->move($rutaCarpeta, $nombreImagen);
                    
                    // Crear registro en BD
                    GaleriaComercio::create([
                        'ID_COMERCIO' => $comercioId,
                        'IMG_URL' => 'images/galeria_comercios/' . $nombreImagen,
                        'DSC_ORDEN' => $ultimoOrden,
                        'FEC_CREACION' => now(),
                        'NUM_ESTADO' => 1,
                    ]);
                }
                
                return redirect()->route('comercios.galeria.index', $comercioId)
                    ->with('success', 'Imágenes subidas exitosamente');
            }
            
            return redirect()->route('comercios.galeria.index', $comercioId)
                ->with('error', 'No se seleccionaron imágenes');
                
        } catch (\Exception $e) {
            return redirect()->route('comercios.galeria.index', $comercioId)
                ->with('error', 'Error al subir imágenes: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar el orden de las imágenes
     */
    public function updateOrder(Request $request, $comercioId)
    {
        try {
            $orden = $request->input('orden', []);
            
            foreach ($orden as $index => $imagenId) {
                GaleriaComercio::where('ID_GALERIA_COMERCIO', $imagenId)
                    ->where('ID_COMERCIO', $comercioId)
                    ->update(['DSC_ORDEN' => $index + 1]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una imagen de la galería
     */
    public function destroy($comercioId, $imagenId)
    {
        try {
            $imagen = GaleriaComercio::where('ID_GALERIA_COMERCIO', $imagenId)
                ->where('ID_COMERCIO', $comercioId)
                ->firstOrFail();
            
            // Eliminar archivo físico
            if ($imagen->IMG_URL && File::exists(public_path($imagen->IMG_URL))) {
                File::delete(public_path($imagen->IMG_URL));
            }
            
            // Eliminar registro
            $imagen->delete();
            
            return redirect()->route('comercios.galeria.index', $comercioId)
                ->with('success', 'Imagen eliminada exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('comercios.galeria.index', $comercioId)
                ->with('error', 'Error al eliminar la imagen: ' . $e->getMessage());
        }
    }
}