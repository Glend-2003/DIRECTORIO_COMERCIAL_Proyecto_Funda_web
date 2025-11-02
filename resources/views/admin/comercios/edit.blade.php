<!-- Modal EDITAR -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-slate-900">Editar Comercio</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mostrar errores generales -->
            @if($errors->any())
            <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <strong class="font-medium">Por favor, corrige los siguientes errores:</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <!-- Nombre del Comercio -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Comercio 
                    </label>
                    <input type="text" 
                           id="edit_DSC_COMERCIO"
                           name="DSC_COMERCIO" 
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           maxlength="500">
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Categorías *
                    </label>
                    <div id="edit_categorias_container" class="border border-slate-300 rounded-lg p-4 max-h-40 overflow-y-auto space-y-2">
                        <!-- Las categorías se cargarán dinámicamente con JavaScript -->
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Selecciona al menos una categoría</p>
                </div>

                <!-- Teléfono y Email -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Teléfono 
                        </label>
                        <input type="text" 
                               id="edit_NUM_TELEFONO"
                               name="NUM_TELEFONO" 
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Email 
                        </label>
                        <input type="email" 
                               id="edit_DSC_CORREO"
                               name="DSC_CORREO" 
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               maxlength="100">
                    </div>
                </div>

                <!-- Dirección -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Dirección
                    </label>
                    <textarea id="edit_DSC_DIRECCION"
                              name="DSC_DIRECCION" 
                              rows="2"
                              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              maxlength="500"></textarea>
                </div>

                <!-- Facebook e Instagram -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Facebook
                        </label>
                        <input type="text" 
                               id="edit_DSC_FACEBOOK"
                               name="DSC_FACEBOOK" 
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               maxlength="255">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Instagram 
                        </label>
                        <input type="text" 
                               id="edit_DSC_INSTAGRAM"
                               name="DSC_INSTAGRAM" 
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               maxlength="255">
                    </div>
                </div>

                <!-- Coordenadas GPS -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Latitud
                        </label>
                        <input type="number" 
                               id="edit_NUM_LATITUD"
                               name="NUM_LATITUD" 
                               step="0.00000001"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               min="-90"
                               max="90">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Longitud
                        </label>
                        <input type="number" 
                               id="edit_NUM_LONGITUD"
                               name="NUM_LONGITUD" 
                               step="0.00000001"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                               min="-180"
                               max="180">
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Estado
                    </label>
                    <select name="NUM_ESTADO" id="edit_NUM_ESTADO" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <!-- Imagen Destacada (URL) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        URL de la Imagen Destacada
                    </label>
                    <input type="text" 
                           id="edit_IMG_DESTACADA"
                           name="IMG_DESTACADA" 
                           placeholder="https://ejemplo.com/imagen.jpg"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-slate-500">Ingresa la URL completa de la imagen. Deja vacío para mantener la imagen actual.</p>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
                <button type="button" 
                        onclick="closeEditModal()" 
                        class="px-4 py-2 text-slate-700 hover:text-slate-900 font-medium">
                    Cancelar
                </button>
                <button type="submit" 
                    class="px-6 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                    Actualizar Comercio
                </button>
            </div>
        </form>
    </div>
</div>