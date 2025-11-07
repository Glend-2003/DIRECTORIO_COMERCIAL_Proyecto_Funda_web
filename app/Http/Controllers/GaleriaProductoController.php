<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\GaleriaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GaleriaProductoController extends Controller
{
    /**
     * Mostrar la galería de un producto específico
     */
    public function index($productoId)
    {
        try {
            $producto = Producto::with('galeria')->findOrFail($productoId);
            $imagenesGaleria = $producto->galeria;
            
            return view('admin.productos.galeria.index', compact('producto', 'imagenesGaleria'));
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Producto no encontrado');
        }
    }

    /**
     * Subir múltiples imágenes a la galería
     */
    public function store(Request $request, $productoId)
    {
        $validator = Validator::make($request->all(), [
            'imagenes.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'imagenes.*.image' => 'Todos los archivos deben ser imágenes',
            'imagenes.*.max' => 'Las imágenes no deben superar los 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('productos.galeria.index', $productoId)
                ->withErrors($validator)
                ->with('error', 'Error al subir las imágenes');
        }

        try {
            $producto = Producto::findOrFail($productoId);
            
            // Contar imágenes actuales
            $cantidadActual = GaleriaProducto::where('ID_PRODUCTO', $productoId)
                ->where('NUM_ESTADO', 1)
                ->count();
            
            if ($request->hasFile('imagenes')) {
                $imagenes = $request->file('imagenes');
                $cantidadNuevas = count($imagenes);
                
                // Validar que no exceda 6 imágenes
                if (($cantidadActual + $cantidadNuevas) > 6) {
                    return redirect()->route('productos.galeria.index', $productoId)
                        ->with('error', 'No puedes subir más de 6 imágenes en total. Actualmente tienes ' . $cantidadActual);
                }
                
                // Obtener el último orden
                $ultimoOrden = GaleriaProducto::where('ID_PRODUCTO', $productoId)
                    ->max('DSC_ORDEN') ?? 0;
                
                foreach ($imagenes as $imagen) {
                    $ultimoOrden++;
                    
                    // Generar nombre único
                    $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                    
                    // Crear directorio si no existe
                    $rutaCarpeta = public_path('images/galeria_productos');
                    if (!File::exists($rutaCarpeta)) {
                        File::makeDirectory($rutaCarpeta, 0755, true);
                    }
                    
                    // Mover imagen
                    $imagen->move($rutaCarpeta, $nombreImagen);
                    
                    // Crear registro en BD
                    GaleriaProducto::create([
                        'ID_PRODUCTO' => $productoId,
                        'IMG_URL' => 'images/galeria_productos/' . $nombreImagen,
                        'DSC_ORDEN' => $ultimoOrden,
                        'FEC_CREACION' => now(),
                        'NUM_ESTADO' => 1,
                    ]);
                }
                
                return redirect()->route('productos.galeria.index', $productoId)
                    ->with('success', 'Imágenes subidas exitosamente');
            }
            
            return redirect()->route('productos.galeria.index', $productoId)
                ->with('error', 'No se seleccionaron imágenes');
                
        } catch (\Exception $e) {
            return redirect()->route('productos.galeria.index', $productoId)
                ->with('error', 'Error al subir imágenes: ' . $e->getMessage());
        }
    }

    /**
     * Actualizar el orden de las imágenes
     */
    public function updateOrder(Request $request, $productoId)
    {
        try {
            $orden = $request->input('orden', []);
            
            foreach ($orden as $index => $imagenId) {
                GaleriaProducto::where('ID_GALERIA_PRODUCTO', $imagenId)
                    ->where('ID_PRODUCTO', $productoId)
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
    public function destroy($productoId, $imagenId)
    {
        try {
            $imagen = GaleriaProducto::where('ID_GALERIA_PRODUCTO', $imagenId)
                ->where('ID_PRODUCTO', $productoId)
                ->firstOrFail();
            
            // Eliminar archivo físico
            if ($imagen->IMG_URL && File::exists(public_path($imagen->IMG_URL))) {
                File::delete(public_path($imagen->IMG_URL));
            }
            
            // Eliminar registro
            $imagen->delete();
            
            return redirect()->route('productos.galeria.index', $productoId)
                ->with('success', 'Imagen eliminada exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('productos.galeria.index', $productoId)
                ->with('error', 'Error al eliminar la imagen: ' . $e->getMessage());
        }
    }
}