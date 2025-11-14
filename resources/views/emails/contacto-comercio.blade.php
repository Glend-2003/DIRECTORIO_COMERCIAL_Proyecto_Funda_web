<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8fafc; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .info-row { margin: 10px 0; padding: 15px; background: white; border-left: 4px solid #2563eb; border-radius: 4px; }
        .label { font-weight: bold; color: #2563eb; display: block; margin-bottom: 5px; }
        .footer { text-align: center; color: #64748b; font-size: 12px; padding: 20px; border-top: 1px solid #e2e8f0; }
        .mensaje-texto { background: #f1f5f9; padding: 15px; border-radius: 4px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2> Nuevo Mensaje de Contacto</h2>
        </div>
        
        <div class="content">
            <p>Hola <strong>{{ $comercio->DSC_NOMBRE_COMERCIO }}</strong>,</p>
            <p>Has recibido un nuevo mensaje de contacto desde el Directorio Comercial:</p>
            
            <div class="info-row">
                <span class="label"> Nombre:</span>
                <span>{{ $nombre }}</span>
            </div>
            
            <div class="info-row">
                <span class="label"> Teléfono:</span>
                <span>{{ $telefono }}</span>
            </div>
            
            <div class="info-row">
                <span class="label"> Correo:</span>
                <span>{{ $correo }}</span>
            </div>
            
            <div class="info-row">
                <span class="label"> Mensaje:</span>
                <div class="mensaje-texto">{{ $mensaje }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Este correo fue enviado desde el formulario de contacto del Directorio Comercial</p>
            <p><strong>Para responder, escribe directamente a:</strong> {{ $correo }}</p>
        </div>
    </div>
</body>
</html>