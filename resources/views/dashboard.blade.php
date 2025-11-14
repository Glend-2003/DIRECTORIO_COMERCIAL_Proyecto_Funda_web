<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .info-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .info-item {
            margin: 15px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-btn:hover {
            background: #c82333;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, {{ Auth::user()->DSC_NOMBRE }}</h1>
    
    <div class="info-card">
        <h2>Información del Administrador</h2>
        <div class="info-item">
            <strong>ID:</strong> {{ Auth::user()->ID_ADMINISTRADOR }}
        </div>
        <div class="info-item">
            <strong>Nombre:</strong> {{ Auth::user()->DSC_NOMBRE }}
        </div>
        <div class="info-item">
            <strong>Correo:</strong> {{ Auth::user()->DSC_CORREO }}
        </div>
        <div class="info-item">
            <strong>Fecha de Creación:</strong> {{ Auth::user()->FEC_CREACION->format('d/m/Y H:i') }}
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Cerrar Sesión</button>
    </form>
</body>
</html>