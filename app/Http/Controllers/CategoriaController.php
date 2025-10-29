<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use Illuminate\Http\Request;

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
        return view('admin.categorias.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'DSC_NOMBRE' => 'nullable|string|max:500',
        'DSC_DESCRIPCION' => 'nullable|string|max:500',
        'IMG_URL' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        $data = $request->except('IMG_URL');

        
        // Manejar la imagen
       if ($request->hasFile('IMG_URL')) {
              $imagen = $request->file('IMG_URL');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('images/categorias'), $nombreImagen);
                $data['IMG_URL'] = 'images/categorias/' . $nombreImagen;
        }

        Categoria::create($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al crear la Categoría: ' . $e->getMessage())
            ->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
        'DSC_NOMBRE' => 'nullable|string|max:500',
        'DSC_DESCRIPCION' => 'nullable|string|max:500',
        'IMG_URL' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        $categoria = Categoria::findOrFail($id);
        $data = $request->except('IMG_URL');

        if ($request->hasFile('IMG_URL')) {
            // Eliminar imagen anterior si existe
            if ($categoria->IMG_URL && file_exists(public_path($categoria->IMG_URL))) {
                unlink(public_path($categoria->IMG_URL));
            }
            
             $imagen = $request->file('IMG_URL');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('images/categorias'), $nombreImagen);
                $data['IMG_URL'] = 'images/categorias/' . $nombreImagen;
        }

       
        Categoria::create($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al crear la Categoría: ' . $e->getMessage())
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
            $categoria->delete();

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la Categoría: ' . $e->getMessage());
        }
    }
}
