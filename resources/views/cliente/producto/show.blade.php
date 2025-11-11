@extends('cliente.layouts.app')

@section('title', $producto->DSC_NOMBRE . ' - ' . $comercio->DSC_NOMBRE_COMERCIO)

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-6 py-4">
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
                <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    Registrar Comercio
                </button>
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
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('comercio.show', $comercio->ID_COMERCIO) }}" class="text-slate-600 hover:text-blue-600">
                                {{ $comercio->DSC_NOMBRE_COMERCIO }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-600">{{ $producto->DSC_NOMBRE }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Content -->
    <div class="container mx-auto px-6 py-12">
        <a href="{{ route('comercio.show', $comercio->ID_COMERCIO) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-blue-600 hover:bg-slate-100 rounded-md transition mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Volver a {{ $comercio->DSC_NOMBRE_COMERCIO }}
        </a>

        <div class="grid lg:grid-cols-2 gap-10 max-w-7xl mx-auto">
            <!-- Images Section -->
            <div>
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-4 shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-[450px] cursor-pointer group" onclick="openLightbox({{ $selectedImage ?? 0 }})">
                        <img id="mainImage"
                             src="{{ asset($galeria[$selectedImage ?? 0] ?? $producto->IMG_IMAGEN_DESTACADA) }}" 
                             alt="{{ $producto->DSC_NOMBRE }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             onerror="this.src='https://images.unsplash.com/photo-1757358957218-67e771ec07bb?crop=entropy&fit=max&fm=jpg&w=800'">
                        @if($producto->categoria)
                        <span class="absolute top-4 left-4 px-3 py-1 text-xs bg-blue-600 text-white rounded-full shadow">
                            {{ $producto->categoria->DSC_NOMBRE }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                @if(count($galeria) > 0)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($galeria as $index => $image)
                    <button onclick="changeImage({{ $index }})"
                            class="thumbnail-btn relative h-24 rounded-lg overflow-hidden border-2 transition-all duration-300 {{ $index === 0 ? 'border-blue-600' : 'border-transparent hover:border-slate-300 hover:scale-105 hover:shadow-md' }}">
                        <img src="{{ asset($image) }}" 
                             alt="Thumbnail {{ $index + 1 }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1757358957218-67e771ec07bb?crop=entropy&fit=max&fm=jpg&w=800'">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <div class="bg-white rounded-xl border border-slate-200 p-10 shadow-md hover:shadow-xl transition-shadow duration-300">
                    <h1 class="text-4xl font-bold text-slate-900 mb-6">{{ $producto->DSC_NOMBRE }}</h1>

                    <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                        <div class="text-3xl font-bold text-blue-600">
                            ₡{{ number_format($producto->MONTO_PRECIO, 0, ',', '.') }}
                        </div>
                        @if($producto->categoria)
                        <span class="px-3 py-1 text-sm bg-slate-100 text-slate-700 rounded-full">
                            {{ $producto->categoria->DSC_NOMBRE }}
                        </span>
                        @endif
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Descripción</h3>
                        <p class="text-slate-600 leading-relaxed text-justify">{{ $producto->DSC_PRODUCTO }}</p>
                    </div>

                    <div class="bg-slate-50 rounded-lg p-4 shadow-inner">
                        <p class="text-sm text-slate-700 mb-1">Disponible en:</p>
                        <a href="{{ route('comercio.show', $comercio->ID_COMERCIO) }}" 
                           class="text-blue-600 hover:underline font-medium">
                            {{ $comercio->DSC_COMERCIO }}
                        </a>
                    </div>
                </div>

                <!-- Additional Info -->
                @if(isset($producto->tiempo_preparacion) || isset($producto->porciones) || isset($producto->tipo))
                <div class="bg-white rounded-xl border border-slate-200 p-8 mt-6 shadow-md hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Información Adicional</h3>
                    <div class="space-y-3 text-sm">
                        @if(isset($producto->tiempo_preparacion))
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-slate-600">Tiempo de preparación</span>
                            <span class="text-slate-900">{{ $producto->tiempo_preparacion }}</span>
                        </div>
                        @endif
                        @if(isset($producto->porciones))
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-slate-600">Porciones</span>
                            <span class="text-slate-900">{{ $producto->porciones }}</span>
                        </div>
                        @endif
                        @if(isset($producto->tipo))
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-slate-600">Tipo</span>
                            <span class="text-slate-900">{{ $producto->tipo }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between py-2">
                            <span class="text-slate-600">Disponibilidad</span>
                            <span class="text-green-600 font-medium">En stock</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($productosRelacionados) && $productosRelacionados->count() > 0)
        <div class="max-w-6xl mx-auto mt-12">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Productos Relacionados</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($productosRelacionados as $item)
                <div class="bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-lg transition cursor-pointer">
                    <div class="relative h-48">
                        <img src="{{ asset($item->IMG_IMAGEN_DESTACADA) }}" 
                             alt="{{ $item->DSC_NOMBRE }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1757358957218-67e771ec07bb?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=300'">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $item->DSC_NOMBRE }}</h3>
                        <div class="flex items-center justify-between">
                            <span class="text-blue-600 font-semibold">₡{{ number_format($item->MONTO_PRECIO, 0, ',', '.') }}</span>
                            <a href="{{ route('producto.show', [$comercio->ID_COMERCIO, $item->ID_COMERCIO]) }}" 
                               class="px-3 py-1 text-sm border border-slate-300 text-slate-700 rounded-md hover:bg-slate-50 transition">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center">
        <button onclick="closeLightbox()" 
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
            <img id="lightboxImage" 
                 src="" 
                 alt=""
                 class="w-full h-full object-contain">
        </div>

        <button onclick="nextImage()" 
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm p-3 rounded-full transition">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <div id="imageCounter" class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white"></div>
    </div>
</div>

<script>
// Gallery images from backend
const galleryImages = @json($galeria ?? []);
let currentImageIndex = 0;

// Change main image
function changeImage(index) {
    currentImageIndex = index;
    const mainImage = document.getElementById('mainImage');
    mainImage.src = '{{ asset('') }}' + galleryImages[index];
    
    // Update thumbnail borders
    document.querySelectorAll('.thumbnail-btn').forEach((btn, i) => {
        if (i === index) {
            btn.classList.remove('border-transparent');
            btn.classList.add('border-blue-600');
        } else {
            btn.classList.remove('border-blue-600');
            btn.classList.add('border-transparent');
        }
    });
}

// Open lightbox
function openLightbox(index) {
    currentImageIndex = index;
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    lightboxImage.src = '{{ asset('') }}' + galleryImages[index];
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    updateCounter();
}

// Close lightbox
function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
}

// Previous image
function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    document.getElementById('lightboxImage').src = '{{ asset('') }}' + galleryImages[currentImageIndex];
    updateCounter();
}

// Next image
function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    document.getElementById('lightboxImage').src = '{{ asset('') }}' + galleryImages[currentImageIndex];
    updateCounter();
}

// Update counter
function updateCounter() {
    document.getElementById('imageCounter').textContent = 
        `${currentImageIndex + 1} / ${galleryImages.length}`;
}

// Close lightbox on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    } else if (e.key === 'ArrowLeft') {
        prevImage();
    } else if (e.key === 'ArrowRight') {
        nextImage();
    }
});
</script>

@endsection