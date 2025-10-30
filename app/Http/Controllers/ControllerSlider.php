<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class ControllerSlider extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'DSC_NOMBRE' => 'required|string|max:100',
            'DSC_DESCRIPCION' => 'nullable|string',
            'IMG_URL' => 'required|url',
            'ESTADO' => 'required|boolean',
        ], [
            'DSC_NOMBRE.required' => 'El nombre es obligatorio.',
            'IMG_URL.required' => 'Debe ingresar una URL para la imagen.',
            'IMG_URL.url' => 'El formato de la URL no es válido.',
            'ESTADO.required' => 'El estado es obligatorio.',
        ]);

        Slider::create($request->all());

        return redirect()->route('sliders.index')->with('success', 'Slider creado exitosamente.');
    }

    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.show', compact('slider'));
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'DSC_NOMBRE' => 'required|string|max:100',
            'DSC_DESCRIPCION' => 'nullable|string',
            'IMG_URL' => 'required|url',
            'ESTADO' => 'required|boolean',
        ]);

        $slider = Slider::findOrFail($id);
        $slider->update($request->all());

        return redirect()->route('sliders.index')->with('success', 'Slider actualizado correctamente.');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider eliminado correctamente.');
    }
}