@extends('admin.layouts.app')

@section('title', 'Gestión de Categorías')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-sm text-slate-600 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <span class="mx-2 text-slate-400">></span>
        <span class="text-slate-900 font-medium">Categorías</span>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Gestión de Categorías</h2>
            <p class="text-slate-600">Administra todas las categorías del directorio</p>
        </div>
        <button onclick="openCreateModal()" 
                class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Categoría
        </button>
    </div>

    <!-- Mensajes de éxito/error -->
    @include('admin.componentes.alertasExitoError')

    <!-- Card con Tabla -->
    <div class="bg-white rounded-lg border">
        <!-- Buscador -->
        <div class="p-6 border-b">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="searchInput"
                       placeholder="Buscar categorías..."
                       class="w-full md:w-96 pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50">
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Imágen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y" id="comerciosTableBody">
                    @forelse($categorias as $categoria)
                    <tr class="hover:bg-slate-50 comercio-row" data-search="{{ strtolower($categoria->DSC_NOMBRE . ' ' . $categoria->DSC_DESCRIPCION) }}">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $categoria->DSC_NOMBRE ?? 'Sin nombre' }}</div>
                            <div class="text-xs text-slate-500">{{ $categoria->FEC_CREACION ? $categoria->FEC_CREACION->format('Y-m-d') : 'N/A' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">{{ $categoria->DSC_DESCRIPCION ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            @if($categoria->IMG_URL)
                                <img src="{{ asset($categoria->IMG_URL) }}" 
                                     alt="{{ $categoria->DSC_DESCRIPCION }}" 
                                     class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                      
                        <td class="px-6 py-4">
                            @if($categoria->NUM_ESTADO == 1)
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Activo
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Botón Ver -->
                                <button type="button" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors view-btn"
                                        title="Ver detalles"
                                        data-id="{{ $categoria->ID_CATEGORIA }}"
                                        data-nombre="{{ $categoria->DSC_NOMBRE }}"
                                        data-descripcion="{{ $categoria->DSC_DESCRIPCION }}"
                                        data-imagen="{{ $categoria->IMG_URL }}"
                                        data-fecha="{{ $categoria->FEC_CREACION }}"
                                        data-estado="{{ $categoria->NUM_ESTADO }}"
                                        onclick="openViewModal(this)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                
                                <!-- Botón Editar -->
                                <button type="button" 
                                        class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors edit-btn"
                                        title="Editar"
                                        data-id="{{ $categoria->ID_CATEGORIA }}"
                                        data-nombre="{{ $categoria->DSC_NOMBRE }}"
                                        data-descripcion="{{ $categoria->DSC_DESCRIPCION }}"
                                        data-imagen="{{ $categoria->IMG_URL }}"
                                        data-fecha="{{ $categoria->FEC_CREACION }}"
                                        data-estado="{{ $categoria->NUM_ESTADO }}"
                                        onclick="openEditModal(this)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                
                                <!-- Botón Eliminar -->
                                <button type="button" 
                                        onclick="confirmDelete({{ $categoria->ID_CATEGORIA }})" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                
                                <!-- Formulario oculto para eliminar -->
                                <form id="deleteForm{{ $categoria->ID_CATEGORIA }}" 
                                      action="{{ route('categorias.destroy', $categoria->ID_CATEGORIA) }}" 
                                      method="POST" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="mb-2">No hay Categorías registradas</p>
                            <button onclick="openCreateModal()" class="text-blue-600 hover:underline font-medium">
                                Crear el primero
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categorias->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $categorias->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Incluir los modales --}}
@include('admin.categorias.form', ['tipo' => 'create', 'categoria' => new stdClass()])
@include('admin.categorias.form', ['tipo' => 'edit', 'categoria' => new stdClass()])
@include('admin.categorias.form', ['tipo' => 'view', 'categoria' => new stdClass()])
@include('admin.componentes.delete')

<script>
let deleteCategoriaId = null;

// Auto-cerrar alertas después de 5 segundos
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    if (successAlert) successAlert.remove();
    if (errorAlert) errorAlert.remove();
}, 5000);

// FUNCIONES MODAL CREAR
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Limpiar formulario
    document.getElementById('createModal').querySelector('form').reset();
}

//FUNCIONES MODAL EDITAR
function openEditModal(button) {
    const modal = document.getElementById('editModal');
    const form = modal.querySelector('form');
    
    // Obtener datos del botón
    const id = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');
    const descripcion = button.getAttribute('data-descripcion');
    const imagen = button.getAttribute('data-imagen');
    const estado = button.getAttribute('data-estado');
    
    // Actualizar la acción del formulario
    form.action = `/categorias/${id}`;
    
    // Llenar campos del formulario
    form.querySelector('[name="DSC_NOMBRE"]').value = nombre || '';
    form.querySelector('[name="DSC_DESCRIPCION"]').value = descripcion || '';
    
    // Solo actualizar estado si existe el campo
    const estadoField = form.querySelector('[name="NUM_ESTADO"]');
    if (estadoField) {
        estadoField.value = estado || '1';
    }
    
    // Mostrar imagen actual si existe
    const imagenPreview = document.getElementById('imagen-preview-editModal');
    if (imagenPreview && imagen && imagen !== 'null' && imagen !== '') {
        const imgElement = imagenPreview.querySelector('img');
        imgElement.src = '/' + imagen;
        imgElement.alt = nombre;
        imagenPreview.classList.remove('hidden');
    } else if (imagenPreview) {
        imagenPreview.classList.add('hidden');
    }
    
    // Mostrar modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Ocultar preview de imagen al cerrar
    const imagenPreview = document.getElementById('imagen-preview-editModal');
    if (imagenPreview) {
        imagenPreview.classList.add('hidden');
    }
}

//FUNCIONES MODAL VER
function openViewModal(button) {
    const modal = document.getElementById('viewModal');
    const form = modal.querySelector('form');
    
    // Obtener datos del botón
    const nombre = button.getAttribute('data-nombre');
    const descripcion = button.getAttribute('data-descripcion');
    const imagen = button.getAttribute('data-imagen');
    const estado = button.getAttribute('data-estado');
    
    // Llenar campos del formulario (readonly)
    form.querySelector('[name="DSC_NOMBRE"]').value = nombre || '';
    form.querySelector('[name="DSC_DESCRIPCION"]').value = descripcion || '';
    if (form.querySelector('[name="NUM_ESTADO"]')) {
        form.querySelector('[name="NUM_ESTADO"]').value = estado || '1';
    }
    
    // Mostrar imagen si existe
    const imagenPreview = document.getElementById('imagen-preview-viewModal');
    if (imagenPreview && imagen && imagen !== 'null' && imagen !== '') {
        const imgElement = imagenPreview.querySelector('img');
        imgElement.src = '/' + imagen;
        imgElement.alt = nombre;
        imagenPreview.classList.remove('hidden');
    } else if (imagenPreview) {
        imagenPreview.classList.add('hidden');
    }
    
    // Mostrar modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeViewModal() {
    const modal = document.getElementById('viewModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Ocultar preview de imagen al cerrar
    const imagenPreview = document.getElementById('imagen-preview-viewModal');
    if (imagenPreview) {
        imagenPreview.classList.add('hidden');
    }
}

// FUNCIONES MODAL ELIMINAR
function confirmDelete(id) {
    deleteCategoriaId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    deleteCategoriaId = null;
}

function executeDelete() {
    if (deleteCategoriaId) {
        document.getElementById('deleteForm' + deleteCategoriaId).submit();
    }
}

// FUNCIONALIDAD DE BÚSQUEDA
document.addEventListener('DOMContentLoaded', function() {
    // Buscador
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.comercio-row');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            const emptyRow = document.getElementById('emptyRow');
            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        });
    }

    // Cerrar modales al hacer clic fuera
    const modals = ['createModal', 'editModal', 'viewModal', 'deleteModal'];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    switch(modalId) {
                        case 'createModal':
                            closeCreateModal();
                            break;
                        case 'editModal':
                            closeEditModal();
                            break;
                        case 'viewModal':
                            closeViewModal();
                            break;
                        case 'deleteModal':
                            closeDeleteModal();
                            break;
                    }
                }
            });
        }
    });
});

// Cerrar modales con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
        closeViewModal();
        closeDeleteModal();
    }
});

console.log('JavaScript de categorías cargado correctamente');
</script>
@endsection