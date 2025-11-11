<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;
use Illuminate\Support\Facades\Log;

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
            'IMG_URL' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'NUM_ESTADO' => 'required|boolean',
        ]);

        try {
            if (!$request->hasFile('IMG_URL') || !$request->file('IMG_URL')->isValid()) {
                throw new Exception('El archivo de imagen no es válido.');
            }

            $uploadedFile = $request->file('IMG_URL');
            $imageUrl = null;

            // FORZAR SUBIDA A CLOUDINARY - Intentar hasta 3 veces
            $maxAttempts = 3;
            $attempt = 0;
            $success = false;

            while ($attempt < $maxAttempts && !$success) {
                $attempt++;
                Log::info("Intento $attempt de subir a Cloudinary");

                try {
                    $cloudinaryUrl = env('CLOUDINARY_URL');

                    if (empty($cloudinaryUrl)) {
                        throw new Exception('CLOUDINARY_URL no está configurada en .env');
                    }

                    // Parsear la URL de Cloudinary
                    preg_match('/cloudinary:\/\/(.*):(.*)@(.*)/', $cloudinaryUrl, $matches);

                    if (count($matches) !== 4) {
                        throw new Exception('Formato de CLOUDINARY_URL inválido');
                    }

                    $apiKey = $matches[1];
                    $apiSecret = $matches[2];
                    $cloudName = $matches[3];

                    $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

                    // Preparar datos para la subida
                    $postData = [
                        'file' => new \CURLFile($uploadedFile->getRealPath()),
                        'upload_preset' => 'ml_default', // Usar upload preset sin firmar
                        'folder' => 'sliders',
                        'timestamp' => time()
                    ];

                    // Si no tienes upload_preset, usar autenticación con API key/secret
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilitar SSL solo para desarrollo
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                    // Si falla con upload_preset, intentar con autenticación básica
                    curl_setopt($ch, CURLOPT_USERPWD, "{$apiKey}:{$apiSecret}");

                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $error = curl_error($ch);
                    curl_close($ch);

                    if ($httpCode === 200) {
                        $result = json_decode($response, true);
                        $imageUrl = $result['secure_url'] ?? null;

                        if ($imageUrl) {
                            Log::info('Imagen subida exitosamente a Cloudinary: ' . $imageUrl);
                            $success = true;
                            break; // Salir del loop si fue exitoso
                        } else {
                            throw new Exception('No se pudo obtener URL segura de Cloudinary');
                        }
                    } else {
                        throw new Exception("Error HTTP {$httpCode} - {$error}. Respuesta: " . $response);
                    }
                } catch (Exception $cloudinaryError) {
                    Log::warning("Intento $attempt fallado: " . $cloudinaryError->getMessage());

                    if ($attempt === $maxAttempts) {
                        // Si es el último intento, lanzar excepción
                        throw new Exception("No se pudo subir a Cloudinary después de $maxAttempts intentos: " . $cloudinaryError->getMessage());
                    }

                    // Esperar 1 segundo antes del siguiente intento
                    sleep(1);
                }
            }

            // Si llegamos aquí, Cloudinary funcionó
            Log::info('Creando slider con URL de Cloudinary: ' . $imageUrl);

            // Crear slider con URL de Cloudinary
            Slider::create([
                'DSC_NOMBRE' => $request->DSC_NOMBRE,
                'DSC_DESCRIPCION' => $request->DSC_DESCRIPCION,
                'IMG_URL' => $imageUrl,
                'NUM_ESTADO' => $request->NUM_ESTADO,
            ]);

            Log::info('Slider creado exitosamente en BD con URL de Cloudinary');

            return redirect()->route('sliders.index')
                ->with('success', 'Slider creado exitosamente. Imagen almacenada en Cloudinary.');
        } catch (Exception $e) {
            Log::error('Error crítico al crear slider: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el slider: ' . $e->getMessage());
        }

        // Después de crear el slider, agrega:
Log::info('=== VERIFICACIÓN FINAL ===');
Log::info('Slider creado con ID: ' . $slider->ID_SLIDER);
Log::info('URL de imagen: ' . $slider->IMG_URL);
Log::info('¿Es URL de Cloudinary?: ' . (str_contains($slider->IMG_URL, 'cloudinary.com') ? 'Sí' : 'No'));
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
            'IMG_URL' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'NUM_ESTADO' => 'required|boolean',
        ]);

        $slider = Slider::findOrFail($id);
        $data = $request->only(['DSC_NOMBRE', 'DSC_DESCRIPCION', 'NUM_ESTADO']);

        try {
            // Si se sube una nueva imagen
            if ($request->hasFile('IMG_URL') && $request->file('IMG_URL')->isValid()) {
                $uploadedFile = $request->file('IMG_URL');

                // Subir nueva imagen a Cloudinary
                $cloudinaryUrl = env('CLOUDINARY_URL');
                preg_match('/cloudinary:\/\/(.*):(.*)@(.*)/', $cloudinaryUrl, $matches);

                $apiKey = $matches[1];
                $apiSecret = $matches[2];
                $cloudName = $matches[3];

                $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

                $postData = [
                    'file' => new \CURLFile($uploadedFile->getRealPath()),
                    'upload_preset' => 'ml_default',
                    'folder' => 'sliders'
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_USERPWD, "{$apiKey}:{$apiSecret}");

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 200) {
                    $result = json_decode($response, true);
                    $data['IMG_URL'] = $result['secure_url'];
                    Log::info('Nueva imagen subida a Cloudinary para slider: ' . $data['IMG_URL']);
                } else {
                    throw new Exception('Error al actualizar imagen en Cloudinary');
                }
            }

            $slider->update($data);

            return redirect()->route('sliders.index')
                ->with('success', 'Slider actualizado correctamente.');
        } catch (Exception $e) {
            Log::error('Error al actualizar slider: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el slider: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider eliminado correctamente.');
    }
}
