<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Comercio;
use Illuminate\Http\Request;

class ProductoClienteController extends Controller
{
   public function show($comercioId, $productoId)
{
    try {
        // Obtener el comercio
        $comercio = Comercio::where('NUM_ESTADO', 1)->findOrFail($comercioId);
        
        // Obtener el producto con sus relaciones
        $producto = Producto::with([
            'galeria' => function($query) {
                $query->where('NUM_ESTADO', 1)->orderBy('DSC_ORDEN', 'asc');
            }
        ])
        ->where('NUM_ESTADO', 1)
        ->where('ID_COMERCIO', $comercioId)
        ->findOrFail($productoId);

        // Construir array de galería (imagen destacada + galería)
        $galeria = [];
        
        // Agregar imagen destacada como primera imagen
        if ($producto->IMG_IMAGEN_DESTACADA) {
            $galeria[] = $producto->IMG_IMAGEN_DESTACADA;
        }
        
        // Agregar imágenes de la galería
        foreach ($producto->galeria as $imagen) {
            $galeria[] = $imagen->IMG_URL;
        }

        // Si no hay imágenes, agregar una imagen por defecto
        if (empty($galeria)) {
            $galeria[] = 'images/default-product.jpg';
        }

        // Obtener productos relacionados del mismo comercio (excluyendo el actual)
        $productosRelacionados = Producto::where('ID_COMERCIO', $comercio->ID_COMERCIO)
            ->where('ID_PRODUCTO', '!=', $producto->ID_PRODUCTO)
            ->where('NUM_ESTADO', 1)
            ->limit(3)
            ->get();

        // Índice de imagen seleccionada (por defecto 0)
        $selectedImage = 0;

        return view('cliente.producto.show', compact(
            'producto',
            'comercio',
            'galeria',
            'productosRelacionados',
            'selectedImage'
        ));
        
    } catch (\Exception $e) {
        return redirect()->route('directorio.index')
            ->with('error', 'Producto no encontrado: ' . $e->getMessage());
    }
}
}