@extends('admin.layouts.app')

@section('title', 'Galería de ' . $producto->DSC_NOMBRE)

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-sm text-slate-600 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <span class="mx-2 text-slate-400">></span>
        <a href="{{ route('productos.index') }}" class="hover:text-slate-900 transition-colors">Productos</a>
        <span class="mx-2 text-slate-400">></span>
        <span class="text-slate-900 font-medium">{{ $producto->DSC_NOMBRE }}</span>
        <span class="mx-2 text-slate-400">></span>
        <span class="text-slate-900 font-medium">Galería</span>
    </nav>

    <!-- Header con información del producto -->
    <div class="bg-white rounded-lg border p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                @if($producto->IMG_IMAGEN_DESTACADA)
                    <img src="{{ asset($producto->IMG_IMAGEN_DESTACADA) }}" 
                         alt="{{ $producto->DSC_NOMBRE }}" 
                         class="w-20 h-20 rounded-lg object-cover border border-slate-200">
                @else
                    <div class="w-20 h-20 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-1">{{ $producto->DSC_NOMBRE }}</h2>
                    <p class="text-slate-600">Gestiona las imágenes de la galería del producto</p>
                    <p class="text-sm text-slate-500 mt-1">
                        <span class="font-medium">{{ $imagenesGaleria->count() }}</span> de <span class="font-medium">6</span> imágenes
                    </p>
                </div>
            </div>
            <a href="{{ route('productos.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a productos
            </a>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
    <div id="successAlert" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="errorAlert" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    <!-- Zona de subida de imágenes -->
    @if($imagenesGaleria->count() < 6)
    <div class="bg-white rounded-lg border p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Subir nuevas imágenes</h3>
        
        <form action="{{ route('productos.galeria.store', $producto->ID_PRODUCTO) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              id="uploadForm">
            @csrf
            
            <!-- Drag & Drop Zone -->
            <div id="dropzone" 
                 class="border-2 border-dashed border-slate-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors cursor-pointer bg-slate-50">
                <svg class="w-12 h-12 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <p class="text-lg font-medium text-slate-700 mb-1">Arrastra imágenes aquí o haz clic para seleccionar</p>
                <p class="text-sm text-slate-500">PNG, JPG, GIF, WEBP hasta 2MB</p>
                <p class="text-xs text-slate-400 mt-2">Puedes subir hasta {{ 6 - $imagenesGaleria->count() }} imágenes más</p>
                
                <input type="file" 
                       name="imagenes[]" 
                       id="fileInput" 
                       multiple 
                       accept="image/*" 
                       class="hidden"
                       max="{{ 6 - $imagenesGaleria->count() }}">
            </div>
            
            <!-- Preview de imágenes seleccionadas -->
            <div id="previewContainer" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 hidden">
            </div>
            
            <div class="mt-4 flex justify-end">
                <button type="submit" 
                        id="uploadButton"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    Subir imágenes
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg">
        <p class="font-medium">Has alcanzado el límite de 6 imágenes</p>
        <p class="text-sm">Elimina algunas imágenes si deseas subir nuevas</p>
    </div>
    @endif

    <!-- Grid de imágenes de la galería -->
    <div class="bg-white rounded-lg border p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-900">Imágenes de la galería</h3>
            @if($imagenesGaleria->count() > 0)
            <p class="text-sm text-slate-600">Arrastra para reordenar</p>
            @endif
        </div>

        @if($imagenesGaleria->count() > 0)
        <div id="galeriaGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($imagenesGaleria as $imagen)
            <div class="galeria-item group relative bg-slate-50 rounded-lg overflow-hidden border border-slate-200 hover:border-blue-500 transition-all cursor-move"
                 data-id="{{ $imagen->ID_GALERIA_PRODUCTO }}">
                
                <!-- Número de orden -->
                <div class="absolute top-2 left-2 bg-slate-900/80 text-white text-xs font-bold px-2 py-1 rounded z-10">
                    #{{ $imagen->DSC_ORDEN }}
                </div>
                
                <!-- Imagen -->
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset($imagen->IMG_URL) }}" 
                         alt="Imagen {{ $imagen->DSC_ORDEN }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200">
                </div>
                
                <!-- Acciones -->
                <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/60 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="flex gap-2">
                        <!-- Vista previa -->
                        <button type="button"
                                onclick="openImageModal('{{ asset($imagen->IMG_URL) }}')"
                                class="p-2 bg-white text-slate-700 rounded-lg hover:bg-slate-100 transition-colors"
                                title="Ver imagen">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        
                        <!-- Eliminar -->
                        <button type="button"
                                onclick="confirmDelete({{ $imagen->ID_GALERIA_PRODUCTO }})"
                                class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                title="Eliminar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Formulario oculto para eliminar -->
                <form id="deleteForm{{ $imagen->ID_GALERIA_PRODUCTO }}" 
                      action="{{ route('productos.galeria.destroy', [$producto->ID_PRODUCTO, $imagen->ID_GALERIA_PRODUCTO]) }}" 
                      method="POST" 
                      class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-slate-500 mb-2">No hay imágenes en la galería</p>
            <p class="text-sm text-slate-400">Sube las primeras imágenes usando el área de arriba</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal para vista previa de imagen -->
<div id="imageModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImageModal()" 
                class="absolute -top-12 right-0 text-white hover:text-slate-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg">
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div id="deleteModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Eliminar imagen</h3>
                <p class="text-sm text-slate-600">Esta acción no se puede deshacer</p>
            </div>
        </div>
        
        <p class="text-slate-700 mb-6">¿Estás seguro de que deseas eliminar esta imagen de la galería?</p>
        
        <div class="flex gap-3 justify-end">
            <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 font-medium">
                Cancelar
            </button>
            <button onclick="executeDelete()" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
let deleteImageId = null;

// Auto-cerrar alertas
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    if (successAlert) successAlert.remove();
    if (errorAlert) errorAlert.remove();
}, 5000);

//DRAG & DROP PARA SUBIR ARCHIVO
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');
const uploadButton = document.getElementById('uploadButton');

// Click en dropzone abre selector de archivos
dropzone.addEventListener('click', () => fileInput.click());

// Prevenir comportamiento por defecto
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Efectos visuales al arrastrar
['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, () => {
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, () => {
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });
});

// Manejar drop
dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    fileInput.files = files;
    handleFiles(files);
});

// Manejar selección de archivos
fileInput.addEventListener('change', (e) => {
    handleFiles(e.target.files);
});

function handleFiles(files) {
    previewContainer.innerHTML = '';
    
    if (files.length > 0) {
        previewContainer.classList.remove('hidden');
        uploadButton.disabled = false;
        
        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <div class="aspect-square rounded-lg overflow-hidden border-2 border-slate-200">
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        </div>
                        <div class="absolute top-2 left-2 bg-slate-900/80 text-white text-xs font-bold px-2 py-1 rounded">
                            ${index + 1}
                        </div>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewContainer.classList.add('hidden');
        uploadButton.disabled = true;
    }
}

//SORTABLE PARA REORDENAR IMÁGENES
const galeriaGrid = document.getElementById('galeriaGrid');
if (galeriaGrid) {
    const sortable = new Sortable(galeriaGrid, {
        animation: 150,
        ghostClass: 'opacity-50',
        onEnd: function() {
            updateOrder();
        }
    });
}

function updateOrder() {
    const items = document.querySelectorAll('.galeria-item');
    const orden = Array.from(items).map(item => item.getAttribute('data-id'));
    
    fetch('{{ route("productos.galeria.updateOrder", $producto->ID_PRODUCTO) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ orden: orden })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar números de orden visual
            items.forEach((item, index) => {
                const badge = item.querySelector('.absolute.top-2.left-2');
                if (badge) {
                    badge.textContent = '#' + (index + 1);
                }
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

//MODAL VISTA PREVIA
function openImageModal(url) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    img.src = url;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// MODAL ELIMINAR 
function confirmDelete(id) {
    deleteImageId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    deleteImageId = null;
}

function executeDelete() {
    if (deleteImageId) {
        document.getElementById('deleteForm' + deleteImageId).submit();
    }
}

// Cerrar modal con ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeImageModal();
        closeDeleteModal();
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('imageModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeImageModal();
});

document.getElementById('deleteModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeDeleteModal();
});

console.log('JavaScript de Galería cargado correctamente');
</script>
@endsection