<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoComercioMail;

class ContactoComercioController extends Controller
{
    public function enviar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|ends_with:@gmail.com',
            'mensaje' => 'required|string|max:1000'
        ], [
            'correo.ends_with' => 'El correo debe ser de Gmail (@gmail.com)',
            'nombre.required' => 'El nombre es obligatorio',
            'telefono.required' => 'El teléfono es obligatorio',
            'correo.required' => 'El correo es obligatorio',
            'correo.email' => 'El correo debe ser válido',
            'mensaje.required' => 'El mensaje es obligatorio'
        ]);

        $comercio = Comercio::findOrFail($id);

        if (!$comercio->DSC_CORREO) {
            return response()->json([
                'success' => false,
                'message' => 'Este comercio no tiene correo configurado.'
            ], 400);
        }

        try {
            Mail::to($comercio->DSC_CORREO)->send(new ContactoComercioMail(
                $request->nombre,
                $request->telefono,
                $request->correo,
                $request->mensaje,
                $comercio
            ));

            return response()->json([
                'success' => true,
                'message' => '¡Mensaje enviado con éxito! El comercio te contactará pronto.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor intenta nuevamente.'
            ], 500);
        }
    }
}