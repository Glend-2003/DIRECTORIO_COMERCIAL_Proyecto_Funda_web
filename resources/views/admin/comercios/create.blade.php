<!-- Modal CREAR -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <form action="{{ route('comercios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-slate-900">Agregar Nuevo Comercio</h3>
                <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <!-- Nombre del Comercio -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Comercio *
                    </label>
                    <input type="text" 
                           name="DSC_COMERCIO" 
                           placeholder="Nombre"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Categoría
                    </label>
                    <select name="categoria" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccionar categoría</option>
                        <option value="restaurante">Restaurante</option>
                        <option value="hotel">Hotel</option>
                        <option value="comercio">Comercio</option>
                    </select>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="descripcion" 
                              rows="3"
                              placeholder="Descripción del comercio"
                              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Teléfono y Email -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Teléfono
                        </label>
                        <input type="text" 
                               name="NUM_TELEFONO" 
                               placeholder="+506 2222-3333"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Email
                        </label>
                        <input type="email" 
                               name="DSC_CORREO" 
                               placeholder="info@comercio.com"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Dirección -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Dirección
                    </label>
                    <input type="text" 
                           name="DSC_DIRECCION" 
                           placeholder="Dirección completa"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Facebook e Instagram -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Facebook
                        </label>
                        <input type="text" 
                               name="DSC_FACEBOOK" 
                               placeholder="facebook.com/comercio"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Instagram
                        </label>
                        <input type="text" 
                               name="DSC_INSTAGRAM" 
                               placeholder="@comercio"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Coordenadas GPS -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Latitud
                        </label>
                        <input type="number" 
                               name="NUM_LATITUD" 
                               step="0.00000001"
                               placeholder="9.9281"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Longitud
                        </label>
                        <input type="number" 
                               name="NUM_LONGITUD" 
                               step="0.00000001"
                               placeholder="-84.0907"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Estado
                    </label>
                    <select name="NUM_ESTADO" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <!-- Imagen Destacada -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Imagen Destacada
                    </label>
                    <input type="file" 
                           name="IMG_DESTACADA" 
                           accept="image/*"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
                
                <button type="submit" 
                    class="px-6 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                    Guardar Comercio
                </button>
            </div>
        </form>
    </div>
</div>