<?php

namespace App\Http\Controllers;
use App\Models\Categoria; 
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ComercioController extends Controller
{
    /**
     * Mostrar listado de comercios
     */
    public function index()
    {
        $comercios = Comercio::latest()->paginate(10);

        $categorias = Categoria::where('NUM_ESTADO', 1)
            ->orderBy('DSC_NOMBRE')
            ->get();
            
        return view('admin.comercios.index', compact('comercios', 'categorias'));
    }

    /**
     * Mostrar formulario para crear comercio
     */
    public function create()
    {
        // Cargar categorías activas para el formulario
        $categorias = Categoria::where('NUM_ESTADO', 1)
            ->orderBy('DSC_NOMBRE')
            ->get();
            
        return view('admin.comercios.create', compact('categorias'));
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
            'IMG_DESTACADA' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'categorias' => 'required|array|min:1',
            'categorias.*' => 'exists:tb_categoria,ID_CATEGORIA',
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
            'IMG_DESTACADA.image' => 'El archivo debe ser una imagen',
            'IMG_DESTACADA.mimes' => 'La imagen debe ser jpeg, png, jpg, gif o webp',
            'IMG_DESTACADA.max' => 'La imagen no debe superar los 2MB',
            'categorias.required' => 'Debes seleccionar al menos una categoría',
            'categorias.min' => 'Debes seleccionar al menos una categoría',
            'categorias.*.exists' => 'Una o más categorías seleccionadas no existen',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor, corrige los errores en el formulario.');
        }

        try {
            // Separar datos del comercio y categorías
            $data = $request->except('categorias');
            $data['NUM_ESTADO'] = 1;

            // Manejar la imagen
            if ($request->hasFile('IMG_DESTACADA')) {
                $imagen = $request->file('IMG_DESTACADA');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                
                // Crear directorio si no existe
                $rutaCarpeta = public_path('images/comercios');
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                
                $imagen->move($rutaCarpeta, $nombreImagen);
                $data['IMG_DESTACADA'] = 'images/comercios/' . $nombreImagen;
            }

            // Crear el comercio
            $comercio = Comercio::create($data);

            $categoriasSync = [];
            foreach ($request->categorias as $categoriaId) {
                $categoriasSync[$categoriaId] = [
                    'FEC_CREACION' => now(),
                    'NUM_ESTADO' => 1
                ];
            }

            $comercio->categorias()->attach($categoriasSync);

            return redirect()->route('comercios.index')
                ->with('success', 'Comercio creado exitosamente con sus categorías');
                
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
        $comercio = Comercio::with('categorias')->findOrFail($id);
        return view('admin.comercios.show', compact('comercio'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $comercio = Comercio::with('categorias')->findOrFail($id);
        
        $categorias = Categoria::where('NUM_ESTADO', 1)
            ->orderBy('DSC_NOMBRE')
            ->get();
            
        return view('admin.comercios.edit', compact('comercio', 'categorias'));
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
            'IMG_DESTACADA' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'NUM_ESTADO' => 'required|integer|in:0,1',
            'categorias' => 'required|array|min:1',
            'categorias.*' => 'exists:tb_categoria,ID_CATEGORIA',
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
            'IMG_DESTACADA.image' => 'El archivo debe ser una imagen',
            'IMG_DESTACADA.mimes' => 'La imagen debe ser jpeg, png, jpg, gif o webp',
            'IMG_DESTACADA.max' => 'La imagen no debe superar los 2MB',
            'categorias.required' => 'Debes seleccionar al menos una categoría',
            'categorias.min' => 'Debes seleccionar al menos una categoría',
            'categorias.*.exists' => 'Una o más categorías seleccionadas no existen',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor, corrige los errores en el formulario.');
        }

        try {
            $comercio = Comercio::findOrFail($id);
            
            $data = $request->except('categorias');

            // Manejar la imagen
            if ($request->hasFile('IMG_DESTACADA')) {
                // Eliminar imagen anterior si existe
                if ($comercio->IMG_DESTACADA && File::exists(public_path($comercio->IMG_DESTACADA))) {
                    File::delete(public_path($comercio->IMG_DESTACADA));
                }
                
                $imagen = $request->file('IMG_DESTACADA');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                
                $rutaCarpeta = public_path('images/comercios');
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                
                $imagen->move($rutaCarpeta, $nombreImagen);
                $data['IMG_DESTACADA'] = 'images/comercios/' . $nombreImagen;
            }

            $comercio->update($data);

            $categoriasSync = [];
            foreach ($request->categorias as $categoriaId) {
                $categoriasSync[$categoriaId] = [
                    'FEC_CREACION' => now(),
                    'NUM_ESTADO' => 1
                ];
            }

            $comercio->categorias()->sync($categoriasSync);

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
            
            // Eliminar imagen si existe
            if ($comercio->IMG_DESTACADA && File::exists(public_path($comercio->IMG_DESTACADA))) {
                File::delete(public_path($comercio->IMG_DESTACADA));
            }
            
            $comercio->categorias()->detach();
            
            $comercio->delete();

            return redirect()->route('comercios.index')
                ->with('success', 'Comercio eliminado exitosamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el comercio: ' . $e->getMessage());
        }
    }
}