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
                        <a href="{{ route('categoriasCliente.index') }}" class="text-blue-600 font-medium">Categorías</a>
                       
                    </nav>
                </div>
            </div>
        </header>