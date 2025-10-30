<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Directorio Comercial')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* Evitar scroll horizontal */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }
        
        /* Estilos del slider */
        .slide {
            position: absolute;
            inset: 0;
            transition: opacity 0.5s ease-in-out;
            opacity: 0;
            z-index: 0;
        }
        
        .slide:first-child {
            opacity: 1;
            z-index: 1;
        }
        
        /* Asegurar que las imágenes no se desborden */
        img {
            max-width: 100%;
            height: auto;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    @yield('content')
    
    @stack('scripts')
</body>
</html>