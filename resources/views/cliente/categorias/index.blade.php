@extends('cliente.layouts.app')

@section('title', 'Categorías - Directorio Comercial')

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
                        <a href="{{ route('categorias.cliente') }}" class="text-blue-600 font-medium">Categorías</a>
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
                            <a href="{{ route('directorio.index') }}"
                                class="text-slate-600 hover:text-blue-600">Inicio</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-slate-600">Categorías</span>
                            </div>
                        </li>
                        @if (request('categoria'))
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-blue-600">{{ request('categoria') }}</span>
                                </div>
                            </li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-white border-b">
            <div class="container mx-auto px-4 py-4">
                <form method="GET" action="{{ route('categorias.listado') }}" class="relative max-w-xl">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="buscar" placeholder="Buscar comercios..." value="{{ request('buscar') }}"
                        class="w-full pl-10 pr-10 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @if (request('buscar'))
                        <a href="{{ route('categorias.listado', array_diff_key(request()->query(), ['buscar' => ''])) }}"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    @endif
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    <input type="hidden" name="ubicacion" value="{{ request('ubicacion') }}">
                    <input type="hidden" name="orden" value="{{ request('orden', 'reciente') }}">
                </form>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <!-- Categorías -->
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                        <div class="p-4 border-b">
                            <h3 class="font-semibold text-slate-900">Categorías</h3>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('categorias.listado') }}"
                                class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition {{ !request('categoria') ? 'bg-blue-50 text-blue-600' : 'text-slate-700' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span class="text-sm">Todas las categorías</span>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs bg-slate-100 text-slate-600 rounded-full">{{ $totalComercios }}</span>
                            </a>

                            @foreach ($categorias as $cat)
                                <a href="{{ route('categorias.listado', array_merge(request()->query(), ['categoria' => $cat->DSC_NOMBRE])) }}"
                                    class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition {{ request('categoria') == $cat->DSC_NOMBRE ? 'bg-blue-50 text-blue-600' : 'text-slate-700' }}">
                                    <div class="flex items-center gap-3">
                                        @if ($cat->IMG_URL)
                                            <img src="{{ asset($cat->IMG_URL) }}" alt="{{ $cat->DSC_NOMBRE }}"
                                                class="w-5 h-5 object-cover rounded">
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                        @endif
                                        <span class="text-sm">{{ $cat->DSC_NOMBRE }}</span>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs bg-slate-100 text-slate-600 rounded-full">{{ $cat->comercios_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mt-4">
                        <div class="p-4 border-b flex items-center justify-between">
                            <h3 class="font-semibold text-slate-900">Filtros</h3>
                            @if (request()->hasAny(['ubicacion']))
                                <a href="{{ route('categorias.listado', ['categoria' => request('categoria')]) }}"
                                    class="text-xs text-blue-600 hover:text-blue-700">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                        <div class="p-4">
                            <form method="GET" action="{{ route('categorias.listado') }}">
                                <!-- Ubicación -->
                                <div class="mb-4">
                                    <label class="text-sm text-slate-700 mb-2 block">Ubicación</label>
                                    <div class="relative">
                                        <input type="text" name="ubicacion" placeholder="Ciudad o zona"
                                            value="{{ request('ubicacion') }}"
                                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                        @if (request('ubicacion'))
                                            <a href="{{ route('categorias.listado', array_diff_key(request()->query(), ['ubicacion' => ''])) }}"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                                <input type="hidden" name="buscar" value="{{ request('buscar') }}">
                                <input type="hidden" name="orden" value="{{ request('orden', 'reciente') }}">

                                <button type="submit"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">
                                    Aplicar Filtros
                                </button>
                            </form>

                            <!-- Filtros Activos -->
                            @if (request('ubicacion'))
                                <div class="mt-4 pt-4 border-t">
                                    <p class="text-xs text-slate-600 mb-2">Filtros activos:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @if (request('ubicacion'))
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-700 rounded text-xs">
                                                📍 {{ request('ubicacion') }}
                                                <a href="{{ route('categorias.listado', array_diff_key(request()->query(), ['ubicacion' => ''])) }}"
                                                    class="hover:text-slate-900">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Header con ordenamiento -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">
                                {{ request('categoria') ?? 'Todos los comercios' }}
                            </h2>
                            <p class="text-slate-600 mt-1">
                                {{ $comercios->total() }} comercio{{ $comercios->total() != 1 ? 's' : '' }}
                                encontrado{{ $comercios->total() != 1 ? 's' : '' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                            </svg>
                            <form method="GET" action="{{ route('categorias.listado') }}" id="ordenForm">
                                <select name="orden" onchange="document.getElementById('ordenForm').submit()"
                                    class="border border-slate-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="reciente" {{ request('orden', 'reciente') == 'reciente' ? 'selected' : '' }}>
                                        Más recientes
                                    </option>
                                    <option value="nombre_asc" {{ request('orden') == 'nombre_asc' ? 'selected' : '' }}>A-Z
                                    </option>
                                    <option value="nombre_desc" {{ request('orden') == 'nombre_desc' ? 'selected' : '' }}>
                                        Z-A</option>
                                </select>
                                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                                <input type="hidden" name="buscar" value="{{ request('buscar') }}">
                                <input type="hidden" name="ubicacion" value="{{ request('ubicacion') }}">
                            </form>
                        </div>
                    </div>

                    <!-- Results -->
                    @if ($comercios->count() > 0)
                        <div class="space-y-6">
                            @foreach ($comercios as $comercio)
                                <div
                                    class="bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-lg transition cursor-pointer">
                                    <div class="grid md:grid-cols-3 gap-0">
                                        <div class="relative h-48 md:h-auto">
                                            <img src="{{ $comercio->IMG_DESTACADA }}" alt="{{ $comercio->DSC_COMERCIO }}"
                                                class="w-full h-full object-cover"
                                                onerror="this.src='https://images.unsplash.com/photo-1464854860390-e95991b46441?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=400'">
                                        </div>
                                        <div class="md:col-span-2 p-6">
                                            <div class="flex items-start justify-between mb-3">
                                                <div>
                                                    <h3 class="text-xl font-semibold text-slate-900 mb-2">
                                                        {{ $comercio->DSC_COMERCIO }}
                                                    </h3>
                                                    @if ($comercio->categorias->isNotEmpty())
                                                        <span
                                                            class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                                            {{ $comercio->categorias->first()->DSC_NOMBRE }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 text-slate-600 text-sm mb-4">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $comercio->DSC_DIRECCION }}
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-4 text-slate-600 text-sm">
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                            </path>
                                                        </svg>
                                                        {{ $comercio->NUM_TELEFONO }}
                                                    </div>
                                                </div>
                                                <a href="#"
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
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        @if ($comercios->hasPages())
                            <div class="mt-8">
                                {{ $comercios->links() }}
                            </div>
                        @endif
                    @else
                        <!-- No results -->
                        <div class="bg-white rounded-lg border border-slate-200 p-12 text-center">
                            <div class="max-w-md mx-auto">
                                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <h3 class="text-xl font-semibold text-slate-900 mb-2">No se encontraron resultados</h3>
                                <p class="text-slate-600 mb-6">
                                    No hay comercios que coincidan con los filtros seleccionados. Intenta ajustar tus
                                    criterios de búsqueda.
                                </p>
                                <a href="{{ route('categorias.listado') }}"
                                    class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    Limpiar Filtros
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
@endsection