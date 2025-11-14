<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoComercioMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $telefono;
    public $correo;
    public $mensaje;
    public $comercio;

    public function __construct($nombre, $telefono, $correo, $mensaje, $comercio)
    {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->mensaje = $mensaje;
        $this->comercio = $comercio;
    }

    public function build()
    {
        return $this->subject('Nuevo mensaje de contacto - Directorio Comercial')
                    ->view('emails.contacto-comercio');
    }
}