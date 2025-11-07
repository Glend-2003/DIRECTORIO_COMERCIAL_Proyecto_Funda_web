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