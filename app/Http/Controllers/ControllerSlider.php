<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class ControllerSlider extends Controller
{
    /**
     * Muestra todos los sliders.
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('sliders.index', compact('sliders'));
    }

    /**
     * Guarda un nuevo slider.
     */
    public function store(Request $request)
    {
        $request->validate([
            'DSC_NOMBRE' => 'required|string|max:100',
            'DSC_DESCRIPCION' => 'nullable|string',
            'IMG_URL' => 'required|url',
        ], [
            'DSC_NOMBRE.required' => 'El nombre es obligatorio.',
            'IMG_URL.required' => 'Debe ingresar una URL para la imagen.',
            'IMG_URL.url' => 'El formato de la URL no es válido.',
        ]);

        Slider::create($request->all());

        return redirect()->route('sliders.index')->with('success', 'Slider creado exitosamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('sliders.edit', compact('slider'));
    }

    /**
     * Actualiza un slider existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'DSC_NOMBRE' => 'required|string|max:100',
            'DSC_DESCRIPCION' => 'nullable|string',
            'IMG_URL' => 'required|url',
        ]);

        $slider = Slider::findOrFail($id);
        $slider->update($request->all());

        return redirect()->route('sliders.index')->with('success', 'Slider actualizado correctamente.');
    }

    /**
     * Elimina un slider.
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider eliminado correctamente.');
    }
}
