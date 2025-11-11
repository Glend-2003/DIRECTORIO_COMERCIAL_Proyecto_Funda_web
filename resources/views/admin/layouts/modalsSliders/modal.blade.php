<!-- Modal para Crear Slider -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-slate-900">Crear Nuevo Slider</h3>
                <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class= "w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Slider *
                    </label>
                    <input type="text" name="DSC_NOMBRE" value="{{ old('DSC_NOMBRE') }}"
                        placeholder="Nombre del slider"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('DSC_NOMBRE') border-red-500 @enderror"
                        required>
                    @error('DSC_NOMBRE')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="DSC_DESCRIPCION" rows="3" placeholder="Descripción del slider"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('DSC_DESCRIPCION') border-red-500 @enderror">{{ old('DSC_DESCRIPCION') }}</textarea>
                    @error('DSC_DESCRIPCION')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Estado *
                    </label>
                    <select name="NUM_ESTADO"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('NUM_ESTADO') border-red-500 @enderror"
                        required>
                        <option value="1" {{ old('NUM_ESTADO') == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('NUM_ESTADO') == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('NUM_ESTADO')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Imagen del Slider *
                    </label>
                    <input type="file" 
                           name="IMG_URL" 
                           id="create_IMG_URL"
                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('IMG_URL') border-red-500 @enderror"
                           required>
                    <p class="mt-1 text-sm text-slate-500">
                        Formatos aceptados: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 5MB
                    </p>
                    @error('IMG_URL')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Vista previa de imagen -->
                    <div id="createImagePreview" class="mt-3 hidden">
                        <p class="text-sm font-medium text-slate-700 mb-2">Vista previa:</p>
                        <img id="createPreview" class="max-w-xs rounded-lg border shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
                <button type="button" onclick="closeCreateModal()"
                    class="px-6 py-2.5 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                    Guardar Slider
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar Slider -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-slate-900">Editar Slider</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Slider *
                    </label>
                    <input type="text" name="DSC_NOMBRE" id="edit_DSC_NOMBRE"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="DSC_DESCRIPCION" id="edit_DSC_DESCRIPCION" rows="3"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Estado *
                    </label>
                    <select name="NUM_ESTADO" id="edit_ESTADO"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div>
                    <!-- Imagen Actual -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Imagen Actual
                        </label>
                        <div class="flex items-center gap-4">
                            <img id="editCurrentImage" src="" 
                                 alt="Imagen actual" 
                                 class="h-20 w-auto rounded-lg border shadow-sm">
                            <span class="text-sm text-slate-500">
                                Imagen actual del slider
                            </span>
                        </div>
                    </div>

                    <!-- Nueva Imagen -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nueva Imagen (Opcional)
                        </label>
                        <input type="file" 
                               name="IMG_URL" 
                               id="edit_IMG_URL"
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-sm text-slate-500">
                            Deje vacío para mantener la imagen actual. Formatos: JPEG, PNG, JPG, GIF, WEBP. Máx: 5MB
                        </p>
                        
                        <!-- Vista previa de nueva imagen -->
                        <div id="editImagePreview" class="mt-3 hidden">
                            <p class="text-sm font-medium text-slate-700 mb-2">Vista previa de nueva imagen:</p>
                            <img id="editPreview" class="max-w-xs rounded-lg border shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
                <button type="button" onclick="closeEditModal()"
                    class="px-6 py-2.5 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                    Actualizar Slider
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Ver Slider -->
<div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header del Modal -->
        <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-slate-900">Detalles del Slider</h3>
            <button type="button" onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-6 space-y-6">
            <!-- Información Básica -->
            <div>
                <label class="text-sm font-medium text-slate-500">Nombre del Slider</label>
                <p id="view_DSC_NOMBRE" class="text-lg font-semibold text-slate-900 mt-1"></p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Estado -->
            <div>
                <label class="text-sm font-medium text-slate-500">Estado</label>
                <p id="view_ESTADO" class="text-slate-900 mt-1"></p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Descripción -->
            <div>
                <label class="text-sm font-medium text-slate-500">Descripción</label>
                <p id="view_DSC_DESCRIPCION" class="text-slate-900 mt-1"></p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Vista Previa -->
            <div>
                <label class="text-sm font-medium text-slate-500">Vista Previa</label>
                <div class="mt-2">
                    <img id="view_IMG_PREVIEW" src="" alt="Vista previa"
                        class="max-w-full h-auto rounded-lg border">
                </div>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Fecha de Creación -->
            <div>
                <label class="text-sm font-medium text-slate-500">Fecha de Creación</label>
                <p id="view_CREATED_AT" class="text-slate-900 mt-1"></p>
            </div>
        </div>

        <!-- Footer del Modal -->
        <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
            <button type="button" onclick="closeViewModal()"
                class="px-6 py-2.5 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                Cerrar
            </button>
        </div>
    </div>
</div>

<!-- Modal para Eliminar Slider -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 text-center mb-2">¿Eliminar slider?</h3>
            <p class="text-sm text-slate-600 text-center mb-6">
                Esta acción no se puede deshacer. El slider será eliminado permanentemente.
            </p>
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
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        Eliminar
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

        // Vista previa de imagen en modal de crear
        document.getElementById('create_IMG_URL')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('createPreview');
            const imagePreview = document.getElementById('createImagePreview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
            }
        });

        // Vista previa de imagen en modal de editar
        document.getElementById('edit_IMG_URL')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('editPreview');
            const imagePreview = document.getElementById('editImagePreview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
            }
        });
    });

    // Funciones para el modal de crear
    function openCreateModal() {
        console.log('Opening create modal');
        const modal = document.getElementById('createModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            console.log('Create modal should be visible now');
        } else {
            console.error('Create modal not found');
        }
    }

    function closeCreateModal() {
        const modal = document.getElementById('createModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Funciones para el modal de editar
    function openEditModal(slider) {
        console.log('Opening edit modal with data:', slider);

        try {
            const modal = document.getElementById('editModal');
            if (!modal) {
                console.error('Edit modal element not found');
                return;
            }

            const nombreInput = document.getElementById('edit_DSC_NOMBRE');
            const descripcionInput = document.getElementById('edit_DSC_DESCRIPCION');
            const estadoSelect = document.getElementById('edit_ESTADO');
            const currentImage = document.getElementById('editCurrentImage');
            const editForm = document.getElementById('editForm');

            if (nombreInput) nombreInput.value = slider.DSC_NOMBRE || '';
            if (descripcionInput) descripcionInput.value = slider.DSC_DESCRIPCION || '';
            if (estadoSelect) estadoSelect.value = slider.NUM_ESTADO || 1;
            if (currentImage && slider.IMG_URL) currentImage.src = slider.IMG_URL;

            // Limpiar vista previa de nueva imagen
            const editPreview = document.getElementById('editPreview');
            const editImagePreview = document.getElementById('editImagePreview');
            if (editPreview) editPreview.src = '';
            if (editImagePreview) editImagePreview.classList.add('hidden');

            // Limpiar input de archivo
            const fileInput = document.getElementById('edit_IMG_URL');
            if (fileInput) fileInput.value = '';

            if (editForm && slider.ID_SLIDER) {
                editForm.action = '/sliders/' + slider.ID_SLIDER;
                console.log('Edit form action:', editForm.action);
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            console.log('Edit modal opened successfully');

        } catch (error) {
            console.error('Error opening edit modal:', error);
        }
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Funciones para el modal de ver
    function openViewModal(slider) {
        console.log('Opening view modal with data:', slider);

        try {
            const modal = document.getElementById('viewModal');
            if (!modal) {
                console.error('View modal element not found');
                return;
            }

            const nombreElement = document.getElementById('view_DSC_NOMBRE');
            const estadoElement = document.getElementById('view_ESTADO');
            const descripcionElement = document.getElementById('view_DSC_DESCRIPCION');
            const previewElement = document.getElementById('view_IMG_PREVIEW');
            const createdAtElement = document.getElementById('view_CREATED_AT');

            if (nombreElement) nombreElement.textContent = slider.DSC_NOMBRE || 'No disponible';
            if (estadoElement) estadoElement.textContent = (slider.NUM_ESTADO == 1 ? 'Activo' : 'Inactivo') || 'No disponible';
            if (descripcionElement) descripcionElement.textContent = slider.DSC_DESCRIPCION || 'No disponible';

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
            document.body.style.overflow = 'hidden';
            console.log('View modal opened successfully');

        } catch (error) {
            console.error('Error opening view modal:', error);
        }
    }

    function closeViewModal() {
        const modal = document.getElementById('viewModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Funciones para el modal de eliminar
    function openDeleteModal(sliderId, sliderName) {
        const nameElement = document.getElementById('deleteSliderName');
        const formElement = document.getElementById('deleteForm');
        const modal = document.getElementById('deleteModal');

        if (nameElement) nameElement.textContent = 'Slider: ' + sliderName;
        if (formElement) formElement.action = '/sliders/' + sliderId;
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
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
        const modals = ['createModal', 'editModal', 'viewModal', 'deleteModal'];

        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal && event.target === modal) {
                if (modalId === 'createModal') closeCreateModal();
                if (modalId === 'editModal') closeEditModal();
                if (modalId === 'viewModal') closeViewModal();
                if (modalId === 'deleteModal') closeDeleteModal();
            }
        });
    });
</script>