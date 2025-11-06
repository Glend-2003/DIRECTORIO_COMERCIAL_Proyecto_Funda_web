@extends('cliente.layouts.app')

@section('title', $comercio->DSC_NOMBRE_COMERCIO . ' - Directorio Comercial')

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="text-slate-900 font-semibold text-lg">Directorio Comercial</span>
                </div>
                <nav class="hidden md:flex gap-6">
                    <a href="{{ route('directorio.index') }}" class="text-slate-600 hover:text-blue-600 transition">Inicio</a>
                    <a href="{{ route('categorias.index') }}" class="text-slate-600 hover:text-blue-600 transition">Categorías</a>
                    <a href="#" class="text-slate-600 hover:text-blue-600 transition">Comercios</a>
                    <a href="#" class="text-slate-600 hover:text-blue-600 transition">Contacto</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('directorio.index') }}" class="text-slate-600 hover:text-blue-600">Inicio</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('categorias.index') }}" class="text-slate-600 hover:text-blue-600">Categorías</a>
                        </div>
                    </li>
                    @if($comercio->categorias->isNotEmpty())
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('categorias.index', ['categoria' => $comercio->categorias->first()->DSC_NOMBRE]) }}" 
                               class="text-slate-600 hover:text-blue-600">
                                {{ $comercio->categorias->first()->DSC_NOMBRE }}
                            </a>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-600">{{ $comercio->DSC_NOMBRE_COMERCIO }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative h-[400px] overflow-hidden">
        <img src="{{ asset($comercio->IMG_DESTACADA) }}" 
             alt="{{ $comercio->DSC_NOMBRE_COMERCIO }}"
             class="w-full h-full object-cover"
             onerror="this.src='https://images.unsplash.com/photo-1464854860390-e95991b46441?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080'">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 text-white p-8">
            <div class="container mx-auto">
                @if($comercio->categorias->isNotEmpty())
                <span class="inline-block px-3 py-1 text-xs bg-blue-600 rounded-full mb-4">
                    {{ $comercio->categorias->first()->DSC_NOMBRE }}
                </span>
                @endif
                <h1 class="text-4xl font-bold text-white mb-2">{{ $comercio->DSC_NOMBRE_COMERCIO }}</h1>
                <div class="flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $comercio->DSC_DIRECCION }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg border border-slate-200 mb-8">
            <div class="flex overflow-x-auto">
                <button onclick="showTab('info')" 
                        class="tab-button flex-1 px-6 py-4 text-sm font-medium border-b-2 border-blue-600 text-blue-600"
                        id="tab-info">
                    Información
                </button>
                <button onclick="showTab('products')" 
                        class="tab-button flex-1 px-6 py-4 text-sm font-medium border-b-2 border-transparent text-slate-600 hover:text-blue-600"
                        id="tab-products">
                    Productos ({{ $comercio->productos->count() }})
                </button>
                <button onclick="showTab('gallery')" 
                        class="tab-button flex-1 px-6 py-4 text-sm font-medium border-b-2 border-transparent text-slate-600 hover:text-blue-600"
                        id="tab-gallery">
                    Galería ({{ $comercio->galeria->count() }})
                </button>
                <button onclick="showTab('contact')" 
                        class="tab-button flex-1 px-6 py-4 text-sm font-medium border-b-2 border-transparent text-slate-600 hover:text-blue-600"
                        id="tab-contact">
                    Contacto
                </button>
            </div>
        </div>

        <!-- Tab: Información -->
        <div id="content-info" class="tab-content">
            <div class="max-w-4xl mx-auto space-y-6">
                <!-- Información de Contacto -->
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Información de Contacto</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Dirección</p>
                                <p class="text-slate-900">{{ $comercio->DSC_DIRECCION }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Teléfono</p>
                                <a href="tel:{{ $comercio->NUM_TELEFONO }}" class="text-slate-900 hover:text-blue-600">{{ $comercio->NUM_TELEFONO }}</a>
                            </div>
                        </div>

                        @if($comercio->DSC_CORREO)
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Email</p>
                                <a href="mailto:{{ $comercio->DSC_CORREO }}" class="text-slate-900 hover:text-blue-600 break-all">{{ $comercio->DSC_CORREO }}</a>
                            </div>
                        </div>
                        @endif

                        @if($comercio->categorias->isNotEmpty())
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Categorías</p>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach($comercio->categorias as $categoria)
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                        {{ $categoria->DSC_NOMBRE }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Redes Sociales -->
                @if($comercio->DSC_FACEBOOK || $comercio->DSC_INSTAGRAM)
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Redes Sociales</h3>
                    <div class="grid md:grid-cols-2 gap-3">
                        @if($comercio->DSC_FACEBOOK)
                        <a href="{{ $comercio->DSC_FACEBOOK }}" target="_blank"
                           class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 hover:border-blue-300 transition">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <div class="overflow-hidden">
                                <p class="text-sm text-slate-500">Facebook</p>
                                <p class="text-slate-900 truncate">{{ $comercio->DSC_FACEBOOK }}</p>
                            </div>
                        </a>
                        @endif
                        
                        @if($comercio->DSC_INSTAGRAM)
                        <a href="{{ $comercio->DSC_INSTAGRAM }}" target="_blank"
                           class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 hover:border-pink-300 transition">
                            <svg class="w-5 h-5 text-pink-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            <div class="overflow-hidden">
                                <p class="text-sm text-slate-500">Instagram</p>
                                <p class="text-slate-900 truncate">{{ $comercio->DSC_INSTAGRAM }}</p>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Ubicación GPS con Mapa Leaflet -->
                @if($comercio->NUM_LATITUD && $comercio->NUM_LONGITUD)
                <div class="bg-white rounded-lg border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Ubicación GPS</h3>
                    
                    <!-- Mapa -->
                    <div id="comercioMap" class="w-full h-80 rounded-lg border-2 border-slate-300 mb-4"></div>
                    
                    <!-- Coordenadas -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Latitud</p>
                            <p class="text-slate-900 font-mono text-sm">{{ $comercio->NUM_LATITUD }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Longitud</p>
                            <p class="text-slate-900 font-mono text-sm">{{ $comercio->NUM_LONGITUD }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab: Productos -->
        <div id="content-products" class="tab-content hidden">
            <div class="max-w-6xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Productos y Servicios</h2>
                    <p class="text-slate-600 mt-1">Explora lo que tenemos para ofrecer</p>
                </div>

                @if($comercio->productos->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($comercio->productos as $producto)
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-lg transition cursor-pointer">
                        <div class="relative h-48">
                            <img src="{{ asset($producto->IMG_IMAGEN_DESTACADA) }}" 
                                 alt="{{ $producto->DSC_NOMBRE }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://images.unsplash.com/photo-1757358957218-67e771ec07bb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=400'">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $producto->DSC_NOMBRE }}</h3>
                            <p class="text-slate-600 text-sm mb-3 line-clamp-2">{{ $producto->DSC_PRODUCTO }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-blue-600 font-semibold">₡{{ number_format($producto->MONTO_PRECIO, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-lg border border-slate-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-slate-500">No hay productos disponibles</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab: Galería -->
        <div id="content-gallery" class="tab-content hidden">
            <div class="max-w-6xl mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Galería de Fotos</h2>
                    <p class="text-slate-600 mt-1">Conoce nuestras instalaciones y ambiente</p>
                </div>

                @if($comercio->galeria->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($comercio->galeria as $index => $imagen)
                    <div class="relative h-64 rounded-lg overflow-hidden cursor-pointer group"
                         onclick="openGallery({{ $index }})">
                        <img src="{{ asset($imagen->IMG_URL) }}" 
                             alt="Galería {{ $index + 1 }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition"></div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-lg border border-slate-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-slate-500">No hay imágenes en la galería</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab: Contacto -->
        <div id="content-contact" class="tab-content hidden">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg border border-slate-200 p-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Contáctanos</h2>
                    <p class="text-slate-600 mb-6">¿Tienes alguna pregunta? Envíanos un mensaje.</p>

                    <form class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-slate-700 mb-2 block">Nombre completo</label>
                                <input type="text" placeholder="Tu nombre" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="text-sm text-slate-700 mb-2 block">Teléfono</label>
                                <input type="text" placeholder="Tu teléfono" 
                                       class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="text-sm text-slate-700 mb-2 block">Correo electrónico</label>
                            <input type="email" placeholder="tu@email.com" 
                                   class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="text-sm text-slate-700 mb-2 block">Mensaje</label>
                            <textarea placeholder="Escribe tu mensaje aquí..." rows="6" 
                                      class="w-full px-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-medium">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div id="galleryModal" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center">
        <button onclick="closeGallery()" 
                class="absolute top-4 right-4 text-white hover:text-slate-300 transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <button onclick="prevImage()" 
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm p-3 rounded-full transition">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <div class="max-w-5xl max-h-[80vh] mx-4">
            <img id="modalImage" src="" alt="" class="w-full h-full object-contain">
        </div>

        <button onclick="nextImage()" 
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm p-3 rounded-full transition">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div id="imageCounter" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white"></div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-12 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span class="font-semibold">Directorio Comercial</span>
                    </div>
                    <p class="text-slate-400 text-sm">
                        Tu plataforma confiable para descubrir los mejores negocios locales.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-white mb-4">Contacto</h3>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            +506 88955772
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Guápiles, Costa Rica
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-8 text-center text-slate-400 text-sm">
                © 2025 Directorio Comercial. Todos los derechos reservados.
            </div>
        </div>
</footer>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Variables globales
const galleryImages = @json($comercio->galeria->map(function($img) { return asset($img->IMG_URL); }));
let currentImageIndex = 0;
let comercioMap = null;

// Inicializar mapa cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    @if($comercio->NUM_LATITUD && $comercio->NUM_LONGITUD)
    // Esperar un poco para que el DOM esté completamente renderizado
    setTimeout(() => {
        initComercioMap();
    }, 500);
    @endif
});

// Inicializar mapa de Leaflet
function initComercioMap() {
    const lat = {{ $comercio->NUM_LATITUD }};
    const lng = {{ $comercio->NUM_LONGITUD }};
    
    // Verificar que el contenedor existe
    const mapContainer = document.getElementById('comercioMap');
    if (!mapContainer) {
        console.error('Contenedor del mapa no encontrado');
        return;
    }
    
    if (comercioMap !== null) {
        comercioMap.remove();
    }
    
    try {
        comercioMap = L.map('comercioMap').setView([lat, lng], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(comercioMap);
        
        const customIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
        
        const marker = L.marker([lat, lng], { icon: customIcon }).addTo(comercioMap);
        marker.bindPopup(`
            <div class="text-center">
                <strong>{{ $comercio->DSC_NOMBRE_COMERCIO }}</strong><br>
                <small>{{ $comercio->DSC_DIRECCION }}</small>
            </div>
        `).openPopup();
        
        // Fix para que el mapa se muestre correctamente
        setTimeout(() => {
            comercioMap.invalidateSize();
        }, 250);
    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
    }
}

// Manejo de tabs
function showTab(tabName) {
    // Ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remover estilos activos de todos los botones
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-600', 'text-blue-600');
        button.classList.add('border-transparent', 'text-slate-600');
    });
    
    // Mostrar contenido seleccionado
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Activar botón seleccionado
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-slate-600');
    activeButton.classList.add('border-blue-600', 'text-blue-600');
    
    // Reinicializar mapa si cambiamos al tab de info
    if (tabName === 'info' && comercioMap !== null) {
        setTimeout(() => {
            comercioMap.invalidateSize();
        }, 100);
    }
}
</script>

@endsection