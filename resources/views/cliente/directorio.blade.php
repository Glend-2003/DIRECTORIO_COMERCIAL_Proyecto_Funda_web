{{-- Layout público para vistas sin autenticación --}}
@extends('cliente.layouts.app')

@section('title', 'Directorio Comercial - Inicio')

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
                        <a href="{{ route('directorio.index') }}"
                            class="text-slate-600 hover:text-blue-600 transition">Inicio</a>
                        <a href="{{ route('categoriasCliente.index') }}"
                        class="text-slate-600 hover:text-blue-600 transition">Categorías</a>
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
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Hero Slider Dinámico -->
        <!-- Hero Slider Dinámico Corregido -->
        <div class="relative overflow-hidden bg-slate-900 h-[500px]" id="heroSlider">
            @if ($sliders->count() > 0)
                @foreach ($sliders as $index => $slider)
                    <div
                        class="slide absolute inset-0 transition-all duration-500 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                        <img src="{{ $slider->IMG_URL }}" alt="{{ $slider->DSC_NOMBRE }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
                        <div class="absolute inset-0 flex items-center">
                            <div class="container mx-auto px-4">
                                <div class="max-w-2xl text-white">
                                    <h1 class="text-5xl font-bold text-white mb-4">{{ $slider->DSC_NOMBRE }}</h1>
                                    <p class="text-white/90 text-xl mb-6">{{ $slider->DSC_DESCRIPCION }}</p>
                                    <button
                                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-lg">
                                        Explorar Ahora
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Slider por defecto si no hay sliders en la base de datos -->
                <div class="slide absolute inset-0 transition-all duration-500 ease-in-out opacity-100 z-10">
                    <img src="https://images.unsplash.com/photo-1464854860390-e95991b46441?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080"
                        alt="Descubre los Mejores Negocios" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl text-white">
                                <h1 class="text-5xl font-bold text-white mb-4">Descubre los Mejores Negocios</h1>
                                <p class="text-white/90 text-xl mb-6">Explora miles de comercios locales y encuentra
                                    exactamente lo que buscas</p>
                                <button
                                    class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-lg">
                                    Explorar Ahora
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($sliders->count() > 1)
                <!-- Slider Controls -->
                <button onclick="changeSlide(-1)"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-full transition z-20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button onclick="changeSlide(1)"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm p-3 rounded-full transition z-20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Slider Dots -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                    @foreach ($sliders as $index => $slider)
                        <button onclick="goToSlide({{ $index }})"
                            class="dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-8' : 'bg-white/50' }}"></button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- El resto del contenido del directorio se mantiene igual -->
        <!-- Search Section -->
        <div class="bg-white shadow-md -mt-12 relative z-10">
            <div class="container mx-auto px-4 py-8">
                <div class="bg-white rounded-lg border border-slate-200 shadow-sm">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4 text-center">¿Qué estás buscando?</h2>
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" placeholder="Buscar comercios, productos o servicios..."
                                    class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <button class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Recent Businesses -->
<div class="container mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Comercios Recientes</h2>
            <p class="text-slate-600 mt-1">Últimos negocios registrados en el directorio</p>
        </div>
        <button class="px-4 py-2 border border-slate-300 rounded-md hover:bg-slate-50 transition">
            Ver Todos
        </button>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @forelse($comerciosRecientes as $comercio)
            <!-- Business Card -->
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-lg transition cursor-pointer group">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $comercio->IMG_DESTACADA }}" 
                         alt="{{ $comercio->DSC_COMERCIO }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                         onerror="this.src='https://images.unsplash.com/photo-1464854860390-e95991b46441?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=400'">
                    
                    @if($comercio->categorias->isNotEmpty())
                        <span class="absolute top-3 right-3 px-2 py-1 bg-blue-600 text-white text-xs rounded-md">
                            {{ $comercio->categorias->first()->DSC_NOMBRE }}
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $comercio->DSC_COMERCIO }}</h3>
                    <div class="flex items-center gap-2 text-slate-600 text-sm mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ Str::limit($comercio->DSC_DIRECCION, 30) }}
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-slate-600 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            {{ $comercio->NUM_TELEFONO }}
                        </div>
                        <a href="{{ route('comercio.show', $comercio->ID_COMERCIO) }}"
                                                    class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-md text-sm text-slate-700 hover:bg-slate-50 transition">
                                                    Ver Detalles
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                    </div>
                </div>
            </div>
        @empty
            <!-- Mensaje cuando no hay comercios -->
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">No hay comercios registrados aún</h3>
                <p class="text-slate-600">Sé el primero en registrar tu negocio</p>
            </div>
        @endforelse
    </div>
</div>

        <!-- Categories -->
        <div class="bg-white py-12">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-slate-900">Categorías Populares</h2>
                    <p class="text-slate-600 mt-2">Explora negocios por categoría</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Category 1 - Restaurantes -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Restaurantes</h3>
                            <p class="text-slate-500 text-sm">45 comercios</p>
                        </div>
                    </div>

                    <!-- Category 2 - Hoteles -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-blue-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Hoteles</h3>
                            <p class="text-slate-500 text-sm">28 comercios</p>
                        </div>
                    </div>

                    <!-- Category 3 - Barberías -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-purple-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Barberías</h3>
                            <p class="text-slate-500 text-sm">32 comercios</p>
                        </div>
                    </div>

                    <!-- Category 4 - Moda -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-pink-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Moda</h3>
                            <p class="text-slate-500 text-sm">56 comercios</p>
                        </div>
                    </div>

                    <!-- Category 5 - Cafeterías -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-amber-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Cafeterías</h3>
                            <p class="text-slate-500 text-sm">38 comercios</p>
                        </div>
                    </div>

                    <!-- Category 6 - Tecnología -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-indigo-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Tecnología</h3>
                            <p class="text-slate-500 text-sm">24 comercios</p>
                        </div>
                    </div>

                    <!-- Category 7 - Alimentación -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-green-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Alimentación</h3>
                            <p class="text-slate-500 text-sm">67 comercios</p>
                        </div>
                    </div>

                    <!-- Category 8 - Entretenimiento -->
                    <div
                        class="bg-white rounded-lg border border-slate-200 hover:shadow-lg transition cursor-pointer group">
                        <div class="p-6 text-center">
                            <div
                                class="bg-rose-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-slate-900 mb-1">Entretenimiento</h3>
                            <p class="text-slate-500 text-sm">19 comercios</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-slate-900 text-white py-12">
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

    @push('scripts')
        <script>
            // Slider functionality - Variables globales
            let currentSlide = 0;
            let slides = [];
            let dots = [];
            let slideInterval;

            // Funciones globales para los botones onclick
            function changeSlide(n) {
                clearInterval(slideInterval);
                currentSlide += n;
                showSlide(currentSlide);
                startAutoSlide();
            }

            function goToSlide(n) {
                clearInterval(slideInterval);
                currentSlide = n;
                showSlide(currentSlide);
                startAutoSlide();
            }

            function showSlide(n) {
                // Validar límites
                if (n >= slides.length) currentSlide = 0;
                else if (n < 0) currentSlide = slides.length - 1;
                else currentSlide = n;

                // Ocultar todos los slides
                slides.forEach(slide => {
                    slide.classList.remove('opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0');
                });

                // Actualizar dots
                dots.forEach(dot => {
                    dot.classList.remove('w-8', 'bg-white');
                    dot.classList.add('bg-white/50', 'w-3');
                });

                // Mostrar slide actual
                if (slides[currentSlide]) {
                    slides[currentSlide].classList.remove('opacity-0', 'z-0');
                    slides[currentSlide].classList.add('opacity-100', 'z-10');
                }

                // Actualizar dot actual
                if (dots[currentSlide]) {
                    dots[currentSlide].classList.add('w-8', 'bg-white');
                    dots[currentSlide].classList.remove('bg-white/50', 'w-3');
                }
            }

            function startAutoSlide() {
                if (slides.length > 1) {
                    clearInterval(slideInterval);
                    slideInterval = setInterval(() => {
                        currentSlide++;
                        showSlide(currentSlide);
                    }, 5000);
                }
            }

            // Inicializar cuando el DOM esté listo
            document.addEventListener('DOMContentLoaded', function() {
                slides = document.querySelectorAll('.slide');
                dots = document.querySelectorAll('.dot');

                // Inicializar slider
                showSlide(currentSlide);
                startAutoSlide();

                // Pausar slider al hacer hover
                const slider = document.getElementById('heroSlider');
                if (slider) {
                    slider.addEventListener('mouseenter', () => {
                        clearInterval(slideInterval);
                    });

                    slider.addEventListener('mouseleave', () => {
                        startAutoSlide();
                    });
                }

                console.log('Slider inicializado correctamente. Slides:', slides.length);
            });
        </script>
    @endpush
@endsection