<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComercioController extends Controller
{
    /**
     * Mostrar listado de comercios
     */
    public function index()
    {
        $comercios = Comercio::latest()->paginate(10);
        return view('admin.comercios.index', compact('comercios'));
    }

    /**
     * Mostrar formulario para crear comercio
     */
    public function create()
    {
        return view('admin.comercios.create');
    }

    /**
     * Guardar nuevo comercio
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'DSC_COMERCIO' => 'nullable|string|max:500',
        'DSC_DIRECCION' => 'nullable|string|max:500',
        'NUM_TELEFONO' => 'nullable|string|max:25',
        'DSC_CORREO' => 'nullable|email|max:100',
        'DSC_INSTAGRAM' => 'nullable|string',
        'DSC_FACEBOOK' => 'nullable|string',
        'NUM_LATITUD' => 'nullable|numeric|between:-90,90',
        'NUM_LONGITUD' => 'nullable|numeric|between:-180,180',
        'IMG_DESTACADA' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'NUM_ESTADO' => 'required|integer|in:0,1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        $data = $request->except('IMG_DESTACADA');

        $data['NUM_ESTADO'] = $request->NUM_ESTADO ? 1 : 0;
        
        // Manejar la imagen
        if ($request->hasFile('IMG_DESTACADA')) {
            $imagen = $request->file('IMG_DESTACADA');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('images/comercios'), $nombreImagen);
            $data['IMG_DESTACADA'] = 'images/comercios/' . $nombreImagen;
        }

        Comercio::create($data);

        return redirect()->route('comercios.index')
            ->with('success', 'Comercio creado exitosamente');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al crear el comercio: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Mostrar un comercio específico
     */
    public function show($id)
    {
        $comercio = Comercio::findOrFail($id);
        return view('admin.comercios.show', compact('comercio'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $comercio = Comercio::findOrFail($id);
        return view('admin.comercios.edit', compact('comercio'));
    }

    /**
     * Actualizar comercio
     */
    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'DSC_COMERCIO' => 'nullable|string|max:500',
        'DSC_DIRECCION' => 'nullable|string|max:500',
        'NUM_TELEFONO' => 'nullable|string|max:25',
        'DSC_CORREO' => 'nullable|email|max:100',
        'DSC_INSTAGRAM' => 'nullable|string',
        'DSC_FACEBOOK' => 'nullable|string',
        'NUM_LATITUD' => 'nullable|numeric|between:-90,90',
        'NUM_LONGITUD' => 'nullable|numeric|between:-180,180',
        'IMG_DESTACADA' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'NUM_ESTADO' => 'required|integer|in:0,1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        $comercio = Comercio::findOrFail($id);
        $data = $request->except('IMG_DESTACADA');

        $data['NUM_ESTADO'] = $request->NUM_ESTADO ? 1 : 0;
        
        // Manejar la imagen
        if ($request->hasFile('IMG_DESTACADA')) {
            // Eliminar imagen anterior si existe
            if ($comercio->IMG_DESTACADA && file_exists(public_path($comercio->IMG_DESTACADA))) {
                unlink(public_path($comercio->IMG_DESTACADA));
            }
            
            $imagen = $request->file('IMG_DESTACADA');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('images/comercios'), $nombreImagen);
            $data['IMG_DESTACADA'] = 'images/comercios/' . $nombreImagen;
        }

        $comercio->update($data);

        return redirect()->route('comercios.index')
            ->with('success', 'Comercio actualizado exitosamente');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al actualizar el comercio: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Eliminar comercio
     */
    public function destroy($id)
    {
        try {
            $comercio = Comercio::findOrFail($id);
            $comercio->delete();

            return redirect()->route('comercios.index')
                ->with('success', 'Comercio eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el comercio: ' . $e->getMessage());
        }
    }
}