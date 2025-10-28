@extends('admin.layouts.app')

@section('title', 'Gestión de Comercios')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="text-sm text-slate-600">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
        <span class="mx-2"></span>
        <span class="text-slate-900">Comercios</span>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Gestión de Comercios</h2>
            <p class="text-slate-600">Administra todos los comercios del directorio</p>
        </div>
        <button onclick="openCreateModal()" 
                class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Comercio
        </button>
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
                       placeholder="Buscar comercios..."
                       class="w-full md:w-96 pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50">
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Comercio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y" id="comerciosTableBody">
                    @forelse($comercios as $comercio)
                    <tr class="hover:bg-slate-50 comercio-row" data-search="{{ strtolower($comercio->DSC_COMERCIO . ' ' . $comercio->NUM_TELEFONO . ' ' . $comercio->DSC_CORREO . ' ' . $comercio->DSC_DIRECCION) }}">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $comercio->DSC_COMERCIO ?? 'Sin nombre' }}</div>
                            <div class="text-xs text-slate-500">{{ $comercio->FEC_CREACION ? $comercio->FEC_CREACION->format('Y-m-d') : 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                General
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">{{ $comercio->NUM_TELEFONO ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $comercio->DSC_CORREO ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                Activo
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Botón Ver -->
                                <button type="button" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors view-btn"
                                        title="Ver detalles"
                                        data-id="{{ $comercio->ID_COMERCIO }}"
                                        data-nombre="{{ $comercio->DSC_COMERCIO }}"
                                        data-telefono="{{ $comercio->NUM_TELEFONO }}"
                                        data-email="{{ $comercio->DSC_CORREO }}"
                                        data-direccion="{{ $comercio->DSC_DIRECCION }}"
                                        data-facebook="{{ $comercio->DSC_FACEBOOK }}"
                                        data-instagram="{{ $comercio->DSC_INSTAGRAM }}"
                                        data-latitud="{{ $comercio->NUM_LATITUD }}"
                                        data-longitud="{{ $comercio->NUM_LONGITUD }}"
                                        data-imagen="{{ $comercio->IMG_DESTACADA }}"
                                        data-fecha="{{ $comercio->FEC_CREACION }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                
                                <!-- Botón Editar -->
                                <button type="button" 
                                        class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors edit-btn"
                                        title="Editar"
                                        data-id="{{ $comercio->ID_COMERCIO }}"
                                        data-nombre="{{ $comercio->DSC_COMERCIO }}"
                                        data-telefono="{{ $comercio->NUM_TELEFONO }}"
                                        data-email="{{ $comercio->DSC_CORREO }}"
                                        data-direccion="{{ $comercio->DSC_DIRECCION }}"
                                        data-facebook="{{ $comercio->DSC_FACEBOOK }}"
                                        data-instagram="{{ $comercio->DSC_INSTAGRAM }}"
                                        data-latitud="{{ $comercio->NUM_LATITUD }}"
                                        data-longitud="{{ $comercio->NUM_LONGITUD }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                
                                <!-- Botón Eliminar -->
                                <button type="button" 
                                        onclick="confirmDelete({{ $comercio->ID_COMERCIO }})" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                
                                <!-- Formulario oculto para eliminar -->
                                <form id="deleteForm{{ $comercio->ID_COMERCIO }}" 
                                      action="{{ route('comercios.destroy', $comercio->ID_COMERCIO) }}" 
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
                            <p class="mb-2">No hay comercios registrados</p>
                            <button onclick="openCreateModal()" class="text-blue-600 hover:underline font-medium">
                                Crear el primero
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($comercios->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $comercios->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Incluir los modales --}}
@include('admin.comercios.create')
@include('admin.comercios.edit')
@include('admin.comercios.view')
@include('admin.comercios.delete')

<script>
// Variable para almacenar el ID del comercio a eliminar
let deleteComercioId = null;

// Auto-cerrar alertas después de 5 segundos
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    if (successAlert) successAlert.remove();
    if (errorAlert) errorAlert.remove();
}, 5000);

// Funciones para Modal CREAR
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Funciones para Modal EDITAR
function openEditModal(button) {
    const comercio = {
        ID_COMERCIO: button.getAttribute('data-id'),
        DSC_COMERCIO: button.getAttribute('data-nombre'),
        NUM_TELEFONO: button.getAttribute('data-telefono'),
        DSC_CORREO: button.getAttribute('data-email'),
        DSC_DIRECCION: button.getAttribute('data-direccion'),
        DSC_FACEBOOK: button.getAttribute('data-facebook'),
        DSC_INSTAGRAM: button.getAttribute('data-instagram'),
        NUM_LATITUD: button.getAttribute('data-latitud'),
        NUM_LONGITUD: button.getAttribute('data-longitud')
    };
    
    console.log('Datos para editar:', comercio);
    
    document.getElementById('editForm').action = `/comercios/${comercio.ID_COMERCIO}`;
    document.getElementById('edit_DSC_COMERCIO').value = comercio.DSC_COMERCIO || '';
    document.getElementById('edit_NUM_TELEFONO').value = comercio.NUM_TELEFONO || '';
    document.getElementById('edit_DSC_CORREO').value = comercio.DSC_CORREO || '';
    document.getElementById('edit_DSC_DIRECCION').value = comercio.DSC_DIRECCION || '';
    document.getElementById('edit_DSC_FACEBOOK').value = comercio.DSC_FACEBOOK || '';
    document.getElementById('edit_DSC_INSTAGRAM').value = comercio.DSC_INSTAGRAM || '';
    document.getElementById('edit_NUM_LATITUD').value = comercio.NUM_LATITUD || '';
    document.getElementById('edit_NUM_LONGITUD').value = comercio.NUM_LONGITUD || '';
    
    document.getElementById('editModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Funciones para Modal VER
function openViewModal(button) {
    const comercio = {
        ID_COMERCIO: button.getAttribute('data-id'),
        DSC_COMERCIO: button.getAttribute('data-nombre'),
        NUM_TELEFONO: button.getAttribute('data-telefono'),
        DSC_CORREO: button.getAttribute('data-email'),
        DSC_DIRECCION: button.getAttribute('data-direccion'),
        DSC_FACEBOOK: button.getAttribute('data-facebook'),
        DSC_INSTAGRAM: button.getAttribute('data-instagram'),
        NUM_LATITUD: button.getAttribute('data-latitud'),
        NUM_LONGITUD: button.getAttribute('data-longitud'),
        IMG_DESTACADA: button.getAttribute('data-imagen'),
        FEC_CREACION: button.getAttribute('data-fecha')
    };
    
    console.log('Datos para ver:', comercio);
    
    document.getElementById('view_DSC_COMERCIO').textContent = comercio.DSC_COMERCIO || 'Sin nombre';
    document.getElementById('view_NUM_TELEFONO').textContent = comercio.NUM_TELEFONO || '-';
    document.getElementById('view_DSC_CORREO').textContent = comercio.DSC_CORREO || '-';
    document.getElementById('view_DSC_DIRECCION').textContent = comercio.DSC_DIRECCION || '-';
    document.getElementById('view_DSC_FACEBOOK').textContent = comercio.DSC_FACEBOOK || '-';
    document.getElementById('view_DSC_INSTAGRAM').textContent = comercio.DSC_INSTAGRAM || '-';
    document.getElementById('view_NUM_LATITUD').textContent = comercio.NUM_LATITUD || '-';
    document.getElementById('view_NUM_LONGITUD').textContent = comercio.NUM_LONGITUD || '-';
    
    // Fecha de creación
    if (comercio.FEC_CREACION) {
        try {
            const fecha = new Date(comercio.FEC_CREACION);
            document.getElementById('view_FEC_CREACION').textContent = fecha.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        } catch (e) {
            document.getElementById('view_FEC_CREACION').textContent = comercio.FEC_CREACION;
        }
    } else {
        document.getElementById('view_FEC_CREACION').textContent = 'N/A';
    }
    
    // Imagen destacada
    if (comercio.IMG_DESTACADA) {
        document.getElementById('view_imagen_container').classList.remove('hidden');
        document.getElementById('view_IMG_DESTACADA').src = '/storage/' + comercio.IMG_DESTACADA;
    } else {
        document.getElementById('view_imagen_container').classList.add('hidden');
    }
    
    document.getElementById('viewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeViewModal() {
    document.getElementById('viewModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Funciones para Modal ELIMINAR
function confirmDelete(id) {
    console.log('Confirmando eliminación:', id);
    deleteComercioId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    deleteComercioId = null;
}

function executeDelete() {
    if (deleteComercioId) {
        document.getElementById('deleteForm' + deleteComercioId).submit();
    }
}

// Funcionalidad de Búsqueda y Event Listeners
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

    // Event listeners para botones de editar
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            openEditModal(this);
        });
    });

    // Event listeners para botones de ver
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function() {
            openViewModal(this);
        });
    });

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

console.log('JavaScript de comercios cargado correctamente');
</script>
@endsection