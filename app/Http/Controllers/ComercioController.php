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
        'DSC_COMERCIO' => 'required|string|max:500',
        'DSC_DIRECCION' => 'required|string|max:500',
        'NUM_TELEFONO' => 'required|string|max:25',
        'DSC_CORREO' => 'required|email|max:100',
        'DSC_INSTAGRAM' => 'nullable|string|max:255',
        'DSC_FACEBOOK' => 'nullable|string|max:255',
        'NUM_LATITUD' => 'required|numeric|between:-90,90',
        'NUM_LONGITUD' => 'required|numeric|between:-180,180',
        'IMG_DESTACADA' => 'required|url|max:500', 
    ], [
        'DSC_COMERCIO.required' => 'El nombre del comercio es obligatorio',
        'DSC_COMERCIO.max' => 'El nombre no puede tener más de 500 caracteres',
        'DSC_DIRECCION.required' => 'La dirección es obligatoria',
        'DSC_DIRECCION.max' => 'La dirección no puede tener más de 500 caracteres',
        'NUM_TELEFONO.required' => 'El teléfono es obligatorio',
        'NUM_TELEFONO.max' => 'El teléfono no puede tener más de 25 caracteres',
        'DSC_CORREO.required' => 'El email es obligatorio',
        'DSC_CORREO.email' => 'El email debe tener un formato válido',
        'DSC_CORREO.max' => 'El email no puede tener más de 100 caracteres',
        'NUM_LATITUD.required' => 'La latitud es obligatoria',
        'NUM_LATITUD.numeric' => 'La latitud debe ser un número',
        'NUM_LATITUD.between' => 'La latitud debe estar entre -90 y 90',
        'NUM_LONGITUD.required' => 'La longitud es obligatoria',
        'NUM_LONGITUD.numeric' => 'La longitud debe ser un número',
        'NUM_LONGITUD.between' => 'La longitud debe estar entre -180 y 180',
        'IMG_DESTACADA.required' => 'La URL de la imagen es obligatoria',
        'IMG_DESTACADA.url' => 'La imagen debe ser una URL válida',
        'IMG_DESTACADA.max' => 'La URL de la imagen no puede tener más de 500 caracteres',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Por favor, corrige los errores en el formulario.');
    }

    try {
        $data = $request->all(); 
        // Forzar el estado a 1 (Activo)
        $data['NUM_ESTADO'] = 1;

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
        'DSC_COMERCIO' => 'required|string|max:500',
        'DSC_DIRECCION' => 'required|string|max:500',
        'NUM_TELEFONO' => 'required|string|max:25',
        'DSC_CORREO' => 'required|email|max:100',
        'DSC_INSTAGRAM' => 'nullable|string|max:255',
        'DSC_FACEBOOK' => 'nullable|string|max:255',
        'NUM_LATITUD' => 'required|numeric|between:-90,90',
        'NUM_LONGITUD' => 'required|numeric|between:-180,180',
        'IMG_DESTACADA' => 'nullable|url|max:500', 
        'NUM_ESTADO' => 'required|integer|in:0,1',
    ], [
        'DSC_COMERCIO.required' => 'El nombre del comercio es obligatorio',
        'DSC_COMERCIO.max' => 'El nombre no puede tener más de 500 caracteres',
        'DSC_DIRECCION.required' => 'La dirección es obligatoria',
        'DSC_DIRECCION.max' => 'La dirección no puede tener más de 500 caracteres',
        'NUM_TELEFONO.required' => 'El teléfono es obligatorio',
        'NUM_TELEFONO.max' => 'El teléfono no puede tener más de 25 caracteres',
        'DSC_CORREO.required' => 'El email es obligatorio',
        'DSC_CORREO.email' => 'El email debe tener un formato válido',
        'DSC_CORREO.max' => 'El email no puede tener más de 100 caracteres',
        'NUM_LATITUD.required' => 'La latitud es obligatoria',
        'NUM_LATITUD.numeric' => 'La latitud debe ser un número',
        'NUM_LATITUD.between' => 'La latitud debe estar entre -90 y 90',
        'NUM_LONGITUD.required' => 'La longitud es obligatoria',
        'NUM_LONGITUD.numeric' => 'La longitud debe ser un número',
        'NUM_LONGITUD.between' => 'La longitud debe estar entre -180 y 180',
        'NUM_ESTADO.required' => 'El estado es obligatorio',
        'NUM_ESTADO.in' => 'El estado debe ser Activo o Inactivo',
        'IMG_DESTACADA.url' => 'La imagen debe ser una URL válida', 
        'IMG_DESTACADA.max' => 'La URL de la imagen no puede tener más de 500 caracteres',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Por favor, corrige los errores en el formulario.');
    }

    try {
        $comercio = Comercio::findOrFail($id);
        $data = $request->all(); 
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