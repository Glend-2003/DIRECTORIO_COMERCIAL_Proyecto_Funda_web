<!-- Modal para Crear Slider -->
<div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeCreateModal()"></div>

        <div
            class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900">Crear Nuevo Slider</h3>
                <p class="text-slate-600">Complete los datos del slider</p>
            </div>

            <form action="{{ route('sliders.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nombre del Slider *
                        </label>
                        <input type="text" name="DSC_NOMBRE" value="{{ old('DSC_NOMBRE') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('DSC_NOMBRE') border-red-500 @enderror"
                            required>
                        @error('DSC_NOMBRE')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Descripción
                        </label>
                        <textarea name="DSC_DESCRIPCION" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('DSC_DESCRIPCION') border-red-500 @enderror">{{ old('DSC_DESCRIPCION') }}</textarea>
                        @error('DSC_DESCRIPCION')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            URL de la Imagen *
                        </label>
                        <input type="url" name="IMG_URL" value="{{ old('IMG_URL') }}"
                            placeholder="https://ejemplo.com/imagen.jpg"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('IMG_URL') border-red-500 @enderror"
                            required>
                        @error('IMG_URL')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Guardar Slider
                    </button>
                    <button type="button" onclick="closeCreateModal()"
                        class="px-6 py-2 border rounded-lg hover:bg-slate-50">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Slider -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeEditModal()"></div>

        <div
            class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900">Editar Slider</h3>
                <p class="text-slate-600">Modifica los datos del slider</p>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nombre del Slider *
                        </label>
                        <input type="text" name="DSC_NOMBRE" id="edit_DSC_NOMBRE"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Descripción
                        </label>
                        <textarea name="DSC_DESCRIPCION" id="edit_DSC_DESCRIPCION" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            URL de la Imagen *
                        </label>
                        <input type="url" name="IMG_URL" id="edit_IMG_URL"
                            placeholder="https://ejemplo.com/imagen.jpg"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Actualizar Slider
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="px-6 py-2 border rounded-lg hover:bg-slate-50">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Slider -->
<div id="viewModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeViewModal()"></div>

        <div
            class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900">Detalles del Slider</h3>
                <p class="text-slate-600">Información completa del slider</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Slider
                    </label>
                    <p id="view_DSC_NOMBRE" class="w-full px-4 py-2 bg-slate-50 rounded-lg text-slate-900"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Descripción
                    </label>
                    <p id="view_DSC_DESCRIPCION" class="w-full px-4 py-2 bg-slate-50 rounded-lg text-slate-900"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        URL de la Imagen
                    </label>
                    <p id="view_IMG_URL" class="w-full px-4 py-2 bg-slate-50 rounded-lg text-slate-900 break-words"></p>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Vista Previa
                        </label>
                        <img id="view_IMG_PREVIEW" src="" alt="Vista previa"
                            class="max-w-full h-auto rounded-lg border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Fecha de Creación
                    </label>
                    <p id="view_CREATED_AT" class="w-full px-4 py-2 bg-slate-50 rounded-lg text-slate-900"></p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeViewModal()"
                    class="px-6 py-2 border rounded-lg hover:bg-slate-50">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Slider -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeDeleteModal()"></div>

        <div
            class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900">Eliminar Slider</h3>
                <p class="text-slate-600">¿Estás seguro de que quieres eliminar este slider?</p>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <span class="text-red-800 font-medium">Esta acción no se puede deshacer</span>
                </div>
                <p class="text-red-700 text-sm mt-2" id="deleteSliderName"></p>
            </div>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Sí, Eliminar
                    </button>
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-6 py-2 border rounded-lg hover:bg-slate-50">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Verificar que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    console.log('Modal scripts loaded successfully');
});

// Funciones para el modal de crear
function openCreateModal() {
    console.log('Opening create modal');
    const modal = document.getElementById('createModal');
    if (modal) {
        modal.classList.remove('hidden');
        console.log('Create modal should be visible now');
    } else {
        console.error('Create modal not found');
    }
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    if (modal) modal.classList.add('hidden');
}

// Funciones para el modal de editar - VERSIÓN SIMPLIFICADA Y SEGURA
function openEditModal(slider) {
    console.log('Opening edit modal with data:', slider);
    
    try {
        // Verificar que el modal existe
        const modal = document.getElementById('editModal');
        if (!modal) {
            console.error('Edit modal element not found');
            return;
        }
        
        // Asignar valores de forma segura
        const nombreInput = document.getElementById('edit_DSC_NOMBRE');
        const descripcionInput = document.getElementById('edit_DSC_DESCRIPCION');
        const urlInput = document.getElementById('edit_IMG_URL');
        const editForm = document.getElementById('editForm');
        
        if (nombreInput) nombreInput.value = slider.DSC_NOMBRE || '';
        if (descripcionInput) descripcionInput.value = slider.DSC_DESCRIPCION || '';
        if (urlInput) urlInput.value = slider.IMG_URL || '';
        
        if (editForm && slider.ID_SLIDER) {
            editForm.action = '/sliders/' + slider.ID_SLIDER;
            console.log('Edit form action:', editForm.action);
        }
        
        modal.classList.remove('hidden');
        console.log('Edit modal opened successfully');
        
    } catch (error) {
        console.error('Error opening edit modal:', error);
    }
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    if (modal) modal.classList.add('hidden');
}

// Funciones para el modal de ver - VERSIÓN SIMPLIFICADA Y SEGURA
function openViewModal(slider) {
    console.log('Opening view modal with data:', slider);
    
    try {
        // Verificar que el modal existe
        const modal = document.getElementById('viewModal');
        if (!modal) {
            console.error('View modal element not found');
            return;
        }
        
        // Asignar valores de forma segura
        const nombreElement = document.getElementById('view_DSC_NOMBRE');
        const descripcionElement = document.getElementById('view_DSC_DESCRIPCION');
        const urlElement = document.getElementById('view_IMG_URL');
        const previewElement = document.getElementById('view_IMG_PREVIEW');
        const createdAtElement = document.getElementById('view_CREATED_AT');
        
        if (nombreElement) nombreElement.textContent = slider.DSC_NOMBRE || 'No disponible';
        if (descripcionElement) descripcionElement.textContent = slider.DSC_DESCRIPCION || 'No disponible';
        if (urlElement) urlElement.textContent = slider.IMG_URL || 'No disponible';
        
        if (previewElement && slider.IMG_URL) {
            previewElement.src = slider.IMG_URL;
            previewElement.style.display = 'block';
        } else if (previewElement) {
            previewElement.style.display = 'none';
        }
        
        if (createdAtElement && slider.created_at) {
            const date = new Date(slider.created_at);
            createdAtElement.textContent = date.toLocaleDateString('es-ES') + ' ' + date.toLocaleTimeString('es-ES');
        } else if (createdAtElement) {
            createdAtElement.textContent = 'No disponible';
        }
        
        modal.classList.remove('hidden');
        console.log('View modal opened successfully');
        
    } catch (error) {
        console.error('Error opening view modal:', error);
    }
}

function closeViewModal() {
    const modal = document.getElementById('viewModal');
    if (modal) modal.classList.add('hidden');
}

// Funciones para el modal de eliminar
function openDeleteModal(sliderId, sliderName) {
    const nameElement = document.getElementById('deleteSliderName');
    const formElement = document.getElementById('deleteForm');
    const modal = document.getElementById('deleteModal');
    
    if (nameElement) nameElement.textContent = 'Slider: ' + sliderName;
    if (formElement) formElement.action = '/sliders/' + sliderId;
    if (modal) modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.add('hidden');
}

// Cerrar modales con ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
        closeViewModal();
        closeDeleteModal();
    }
});

// Cerrar modales haciendo clic fuera
document.addEventListener('click', function(event) {
    const createModal = document.getElementById('createModal');
    const editModal = document.getElementById('editModal');
    const viewModal = document.getElementById('viewModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === createModal) closeCreateModal();
    if (event.target === editModal) closeEditModal();
    if (event.target === viewModal) closeViewModal();
    if (event.target === deleteModal) closeDeleteModal();
});
</script>