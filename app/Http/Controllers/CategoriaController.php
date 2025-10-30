<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::latest()->paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ya no necesitas esta vista, el modal se abre desde index
        return redirect()->route('categorias.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'DSC_NOMBRE' => 'required|string|max:500',
            'DSC_DESCRIPCION' => 'nullable|string|max:500',
            'IMG_URL' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'DSC_NOMBRE.required' => 'El nombre de la categoría es obligatorio',
            'IMG_URL.image' => 'El archivo debe ser una imagen',
            'IMG_URL.max' => 'La imagen no debe superar los 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('categorias.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores del formulario');
        }

        try {
            $data = $request->only(['DSC_NOMBRE', 'DSC_DESCRIPCION']);
            
            // Estado activo por defecto
            $data['NUM_ESTADO'] = 1;

            // Manejar la imagen
            if ($request->hasFile('IMG_URL')) {
                $imagen = $request->file('IMG_URL');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                
                // Crear directorio si no existe
                $rutaCarpeta = public_path('images/categorias');
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                
                $imagen->move($rutaCarpeta, $nombreImagen);
                $data['IMG_URL'] = 'images/categorias/' . $nombreImagen;
            }

            Categoria::create($data);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría creada exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')
                ->with('error', 'Error al crear la categoría: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ya no necesitas esta vista, el modal se abre desde index
        return redirect()->route('categorias.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ya no necesitas esta vista, el modal se abre desde index
        return redirect()->route('categorias.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'DSC_NOMBRE' => 'required|string|max:500',
            'DSC_DESCRIPCION' => 'nullable|string|max:500',
            'IMG_URL' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'NUM_ESTADO' => 'required|in:0,1',
        ], [
            'DSC_NOMBRE.required' => 'El nombre de la categoría es obligatorio',
            'IMG_URL.image' => 'El archivo debe ser una imagen',
            'IMG_URL.max' => 'La imagen no debe superar los 2MB',
            'NUM_ESTADO.required' => 'El estado es obligatorio',
        ]);

        if ($validator->fails()) {
            return redirect()->route('categorias.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor corrige los errores del formulario');
        }

        try {
            $categoria = Categoria::findOrFail($id);
            $data = $request->only(['DSC_NOMBRE', 'DSC_DESCRIPCION', 'NUM_ESTADO']);

            // Manejar la imagen
            if ($request->hasFile('IMG_URL')) {
                // Eliminar imagen anterior si existe
                if ($categoria->IMG_URL && File::exists(public_path($categoria->IMG_URL))) {
                    File::delete(public_path($categoria->IMG_URL));
                }
                
                $imagen = $request->file('IMG_URL');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                
                // Crear directorio si no existe
                $rutaCarpeta = public_path('images/categorias');
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                
                $imagen->move($rutaCarpeta, $nombreImagen);
                $data['IMG_URL'] = 'images/categorias/' . $nombreImagen;
            }

            // Actualizar la categoría (CORREGIDO: era create, debe ser update)
            $categoria->update($data);

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría actualizada exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')
                ->with('error', 'Error al actualizar la categoría: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            
            // Eliminar imagen si existe
            if ($categoria->IMG_URL && File::exists(public_path($categoria->IMG_URL))) {
                File::delete(public_path($categoria->IMG_URL));
            }
            
            $categoria->delete();

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría eliminada exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')
                ->with('error', 'Error al eliminar la categoría: ' . $e->getMessage());
        }
    }
}