@extends('admin.layouts.app')

@section('title', 'Gestión de Productos')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center text-sm text-slate-600 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <span class="mx-2 text-slate-400">></span>
        <span class="text-slate-900 font-medium">Productos</span>
    </nav>

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Gestión de Productos</h2>
            <p class="text-slate-600">Administra todos los Productos del directorio</p>
        </div>
        <button onclick="openCreateModal()" 
                class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Productos
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
                       placeholder="Buscar Productos..."
                       class="w-full md:w-96 pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50">
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Productos</th>                       
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Comercio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Imágen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y" id="comerciosTableBody">
                    @forelse($productos as $producto)
                    <tr class="hover:bg-slate-50 comercio-row" data-search="{{ strtolower($producto->DSC_NOMBRE . ' ' . $producto->DSC_PRODUCTO) }}">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $producto->DSC_NOMBRE ?? 'Sin nombre' }}</div>
                            <div class="text-xs text-slate-500">{{ $producto->FEC_CREACION ? $producto->FEC_CREACION->format('Y-m-d') : 'N/A' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">{{ $producto->DSC_PRODUCTO ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">
                              {{ $producto->comercio->DSC_NOMBRE_COMERCIO ?? 'Sin comercio' }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($producto->IMG_IMAGEN_DESTACADA)
                                <img src="{{ asset($producto->IMG_IMAGEN_DESTACADA) }}" 
                                     alt="{{ $producto->DSC_NOMBRE }}" 
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
                            <div class="text-sm text-slate-900">
                              {{ $producto->MONTO_PRECIO ?? 'Sin monto registrao' }}
                            </div>
                        </td>
                      
                        <td class="px-6 py-4">
                            @if($producto->NUM_ESTADO == 1)
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
        <!-- Botón Galería (NUEVO) -->
        <a href="{{ route('productos.galeria.index', $producto->ID_PRODUCTO) }}"
           class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
           title="Gestionar galería">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </a>
        
        <!-- Botón Ver -->
        <button type="button" 
                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors view-btn"
                title="Ver detalles"
                data-id="{{ $producto->ID_PRODUCTO }}"
                data-nombre="{{ $producto->DSC_NOMBRE }}"
                data-descripcion="{{ $producto->DSC_PRODUCTO }}"
                data-idComercio="{{ $producto->ID_COMERCIO }}"
                data-monto="{{ $producto->MONTO_PRECIO }}"
                data-imagen="{{ $producto->IMG_IMAGEN_DESTACADA }}"
                data-fecha="{{ $producto->FEC_CREACION }}"
                data-estado="{{ $producto->NUM_ESTADO }}"
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
                data-id="{{ $producto->ID_PRODUCTO }}"
                data-nombre="{{ $producto->DSC_NOMBRE }}"
                data-descripcion="{{ $producto->DSC_PRODUCTO }}"
                data-idComercio="{{ $producto->ID_COMERCIO }}"
                data-monto="{{ $producto->MONTO_PRECIO }}"
                data-imagen="{{ $producto->IMG_IMAGEN_DESTACADA }}"
                data-fecha="{{ $producto->FEC_CREACION }}"
                data-estado="{{ $producto->NUM_ESTADO }}"
                onclick="openEditModal(this)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </button>
        
        <!-- Botón Eliminar -->
        <button type="button" 
                onclick="confirmDelete({{ $producto->ID_PRODUCTO }})" 
                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                title="Eliminar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
        
        <!-- Formulario oculto para eliminar -->
        <form id="deleteForm{{ $producto->ID_PRODUCTO }}" 
              action="{{ route('productos.destroy', $producto->ID_PRODUCTO) }}" 
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
                            <p class="mb-2">No hay Productos registrados</p>
                            <button onclick="openCreateModal()" class="text-blue-600 hover:underline font-medium">
                                Crear el primero
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($productos->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $productos->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Incluir los modales --}}
@include('admin.productos.form', ['tipo' => 'create', 'producto' => new stdClass()])
@include('admin.productos.form', ['tipo' => 'edit', 'producto' => new stdClass()])
@include('admin.productos.form', ['tipo' => 'view', 'producto' => new stdClass()])
@include('admin.productos.delete')

<script>
let deleteProductoId = null;

// Auto-cerrar alertas después de 5 segundos
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    if (successAlert) successAlert.remove();
    if (errorAlert) errorAlert.remove();
}, 5000);

//FUNCIONES DE VALIDACIÓN
function validateForm(formId) {
    const form = document.getElementById(formId);
    const alertContainer = form.querySelector('[id^="modalAlert"]');
    let errors = [];
    
    // Validar nombre
    const nombre = form.querySelector('[name="DSC_NOMBRE"]');
    if (!nombre.value.trim()) {
        errors.push('El nombre del producto es obligatorio');
        nombre.classList.add('border-red-500');
    } else {
        nombre.classList.remove('border-red-500');
    }
    
    // Validar comercio
    const comercio = form.querySelector('[name="ID_COMERCIO"]');
    if (comercio && !comercio.value) {
        errors.push('Debes seleccionar un comercio');
        comercio.classList.add('border-red-500');
    } else if (comercio) {
        comercio.classList.remove('border-red-500');
    }
    
    // Validar precio
    const precio = form.querySelector('[name="MONTO_PRECIO"]');
    if (!precio.value || precio.value <= 0) {
        errors.push('El precio debe ser mayor a 0');
        precio.classList.add('border-red-500');
    } else {
        precio.classList.remove('border-red-500');
    }
    
    // Validar imagen (solo si hay archivo)
    const imagen = form.querySelector('[name="IMG_IMAGEN_DESTACADA"]');
    if (imagen && imagen.files.length > 0) {
        const file = imagen.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        
        if (!allowedTypes.includes(file.type)) {
            errors.push('Solo se permiten imágenes (jpeg, png, jpg, gif, webp)');
            imagen.classList.add('border-red-500');
        } else if (file.size > maxSize) {
            errors.push('La imagen no debe superar los 2MB');
            imagen.classList.add('border-red-500');
        } else {
            imagen.classList.remove('border-red-500');
        }
    }
    
    // Mostrar errores
    if (errors.length > 0) {
        showModalAlert(alertContainer, errors, 'error');
        return false;
    }
    
    return true;
}

function showModalAlert(container, messages, type = 'error') {
    const bgColor = type === 'error' ? 'bg-red-50 border-red-200' : 'bg-green-50 border-green-200';
    const textColor = type === 'error' ? 'text-red-800' : 'text-green-800';
    const iconColor = type === 'error' ? 'text-red-600' : 'text-green-600';
    
    const icon = type === 'error' 
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
    
    const messagesList = Array.isArray(messages) 
        ? messages.map(msg => `<li>${msg}</li>`).join('') 
        : `<li>${messages}</li>`;
    
    container.innerHTML = `
        <div class="${bgColor} border ${textColor} px-4 py-3 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 ${iconColor} mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <div class="flex-1">
                    <ul class="list-disc list-inside space-y-1">
                        ${messagesList}
                    </ul>
                </div>
            </div>
        </div>
    `;
    container.classList.remove('hidden');
    
    // Scroll al inicio del modal
    container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

//FUNCIONES MODAL CREAR
function openCreateModal() {
    const modal = document.getElementById('createModal');
    const alertContainer = modal.querySelector('#modalAlertCreate');
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Limpiar alertas previas
    if (alertContainer) {
        alertContainer.classList.add('hidden');
        alertContainer.innerHTML = '';
    }
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    const form = modal.querySelector('form');
    const alertContainer = modal.querySelector('#modalAlertCreate');
    
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Limpiar formulario y errores
    form.reset();
    form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
    if (alertContainer) {
        alertContainer.classList.add('hidden');
        alertContainer.innerHTML = '';
    }
}

//FUNCIONES MODAL EDITAR
function openEditModal(button) {
    const modal = document.getElementById('editModal');
    const form = modal.querySelector('form');
    const alertContainer = modal.querySelector('#modalAlertEdit');
    
    // Obtener datos del botón
    const id = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');
    const descripcion = button.getAttribute('data-descripcion');
    const idComercio = button.getAttribute('data-idComercio');
    const monto = button.getAttribute('data-monto');
    const imagen = button.getAttribute('data-imagen');
    const estado = button.getAttribute('data-estado');
    
    // Actualizar la acción del formulario
    form.action = `/productos/${id}`;
    
    // Llenar campos del formulario
    form.querySelector('[name="DSC_NOMBRE"]').value = nombre || '';
    form.querySelector('[name="DSC_PRODUCTO"]').value = descripcion || '';
    form.querySelector('[name="ID_COMERCIO"]').value = idComercio || '';
    form.querySelector('[name="MONTO_PRECIO"]').value = monto || '';
    
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
    
    // Limpiar alertas previas
    if (alertContainer) {
        alertContainer.classList.add('hidden');
        alertContainer.innerHTML = '';
    }
    
    // Mostrar modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const form = modal.querySelector('form');
    const alertContainer = modal.querySelector('#modalAlertEdit');
    
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Limpiar errores visuales
    form.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
    if (alertContainer) {
        alertContainer.classList.add('hidden');
        alertContainer.innerHTML = '';
    }
    
    // Ocultar preview de imagen
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
    const idComercio = button.getAttribute('data-idComercio');
    const monto = button.getAttribute('data-monto');
    const imagen = button.getAttribute('data-imagen');
    const estado = button.getAttribute('data-estado');
    
    // Llenar campos del formulario (readonly)
    form.querySelector('[name="DSC_NOMBRE"]').value = nombre || '';
    form.querySelector('[name="DSC_PRODUCTO"]').value = descripcion || '';
    
    const comercioField = form.querySelector('[name="ID_COMERCIO"]');
    if (comercioField) {
        comercioField.value = idComercio || '';
    }
    
    form.querySelector('[name="MONTO_PRECIO"]').value = monto || '';
    
    const estadoField = form.querySelector('[name="NUM_ESTADO"]');
    if (estadoField) {
        estadoField.value = estado || '1';
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
    
    const imagenPreview = document.getElementById('imagen-preview-viewModal');
    if (imagenPreview) {
        imagenPreview.classList.add('hidden');
    }
}

//FUNCIONES MODAL ELIMINAR
function confirmDelete(id) {
    deleteProductoId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    deleteProductoId = null;
}

function executeDelete() {
    if (deleteProductoId) {
        document.getElementById('deleteForm' + deleteProductoId).submit();
    }
}

//EVENT LISTENERS
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real para formulario de crear
    const createForm = document.getElementById('formCreate');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateForm('formCreate')) {
                this.submit();
            }
        });
    }
    
    // Validación en tiempo real para formulario de editar
    const editForm = document.getElementById('formEdit');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateForm('formEdit')) {
                this.submit();
            }
        });
    }
    
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
                        case 'createModal': closeCreateModal(); break;
                        case 'editModal': closeEditModal(); break;
                        case 'viewModal': closeViewModal(); break;
                        case 'deleteModal': closeDeleteModal(); break;
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

console.log('JavaScript de Productos cargado correctamente');
</script>
@endsection