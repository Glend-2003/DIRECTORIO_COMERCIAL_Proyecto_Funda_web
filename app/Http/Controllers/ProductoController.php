<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $productos = Producto::with('comercio')->latest()->paginate(10);
    $comercios = Comercio::orderBy('DSC_COMERCIO')->get();
    return view('admin.productos.index', compact('productos', 'comercios'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('productos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'ID_COMERCIO' => 'required|integer',
            'DSC_NOMBRE' => 'required|string|max:500',
            'DSC_PRODUCTO' => 'nullable|string|max:500',
            'MONTO_PRECIO' => 'required|numeric',
            'IMG_IMAGEN_DESTACADA' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'ID_COMERCIO.required' => 'El ID del comercio es obligatorio',
            'DSC_NOMBRE.required' => 'El nombre de la categoría es obligatorio',
            'IMG_IMAGEN_DESTACADA.image' => 'El archivo debe ser una imagen',
            'IMG_IMAGEN_DESTACADA.max' => 'La imagen no debe superar los 2MB',
            'MONTO_PRECIO.required' => 'El precio del producto es obligatorio',
            'MONTO_PRECIO.numeric' => 'El precio del producto debe ser un número',
        ]);

        if ($validator->fails()) {
            return redirect()->route('productos.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores del formulario');
        }

        try {
            $data = $request->all(); 
            // Estado activo por defecto
            $data['NUM_ESTADO'] = 1;

            // Manejar la imagen
            if ($request->hasFile('IMG_IMAGEN_DESTACADA')) {
                $imagen = $request->file('IMG_IMAGEN_DESTACADA');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                
                // Crear directorio si no existe
                $rutaCarpeta = public_path('images/productos');
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                
                $imagen->move($rutaCarpeta, $nombreImagen);
                $data['IMG_IMAGEN_DESTACADA'] = 'images/productos/' . $nombreImagen;
            }

            Producto::create($data);

            return redirect()->route('productos.index')
                ->with('success', 'Producto creado exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Error al crear el Producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('productos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('productos.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'ID_COMERCIO' => 'required|integer',
            'DSC_NOMBRE' => 'required|string|max:500',
            'DSC_PRODUCTO' => 'nullable|string|max:500',
            'MONTO_PRECIO' => 'required|numeric',
            'IMG_IMAGEN_DESTACADA' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'ID_COMERCIO.required' => 'El ID del comercio es obligatorio',
            'DSC_NOMBRE.required' => 'El nombre de la categoría es obligatorio',
            'IMG_IMAGEN_DESTACADA.image' => 'El archivo debe ser una imagen',
            'IMG_IMAGEN_DESTACADA.max' => 'La imagen no debe superar los 2MB',
            'MONTO_PRECIO.required' => 'El precio del producto es obligatorio',
            'MONTO_PRECIO.numeric' => 'El precio del producto debe ser un número',
        ]);

        if ($validator->fails()) {
            return redirect()->route('productos.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores del formulario');
        }

        try {
            $producto = Producto::findOrFail($id);
            $data = $request->all(); 

            // Manejar la imagen
            if ($request->hasFile('IMG_IMAGEN_DESTACADA')) {
                // Eliminar imagen anterior si existe
                // CORRECCIÓN 1: Usar $producto
                if ($producto->IMG_IMAGEN_DESTACADA && File::exists(public_path($producto->IMG_IMAGEN_DESTACADA))) {
                    File::delete(public_path($producto->IMG_IMAGEN_DESTACADA));
                }
                
                // ... (código para subir la nueva imagen)
                $imagen = $request->file('IMG_IMAGEN_DESTACADA');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                
                $rutaCarpeta = public_path('images/productos');
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                
                $imagen->move($rutaCarpeta, $nombreImagen);
                $data['IMG_IMAGEN_DESTACADA'] = 'images/productos/' . $nombreImagen;
            }

            // CORRECCIÓN 2: Actualizar el objeto $producto
            $producto->update($data);

            return redirect()->route('productos.index')
                ->with('success', 'Producto actualizado exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Error al actualizar el Producto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            
            // Eliminar imagen si existe
            if ($producto->IMG_IMAGEN_DESTACADA && File::exists(public_path($producto->IMG_IMAGEN_DESTACADA))) {
                File::delete(public_path($producto->IMG_IMAGEN_DESTACADA));
            }
            
            $producto->delete();

            return redirect()->route('productos.index')
                ->with('success', 'Producto eliminado exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('productos.index')
                ->with('error', 'Error al eliminar el Producto: ' . $e->getMessage());
        }
    
    }
}
