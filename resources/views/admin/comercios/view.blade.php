<!-- Modal VER -->
<div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header del Modal -->
        <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
            <h3 class="text-xl font-bold text-slate-900">Detalle del Comercio</h3>
            <button type="button" onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-6 space-y-6">
            <!-- Imagen Destacada -->
            <div id="view_imagen_container" class="hidden">
                <img id="view_IMG_DESTACADA" src="" alt="Imagen destacada" class="w-full h-48 object-cover rounded-lg">
            </div>

            <!-- Información Básica -->
            <div>
                <label class="text-sm font-medium text-slate-500">Nombre del Comercio</label>
                <p id="view_DSC_COMERCIO" class="text-lg font-semibold text-slate-900 mt-1"></p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Información de Contacto -->
            <div>
                <h4 class="text-sm font-semibold text-slate-900 mb-3">Información de Contacto</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-slate-500">Teléfono</label>
                        <p id="view_NUM_TELEFONO" class="text-slate-900 mt-1"></p>
                    </div>
                    <div>
                        <label class="text-sm text-slate-500">Email</label>
                        <p id="view_DSC_CORREO" class="text-slate-900 mt-1"></p>
                    </div>
                </div>
            </div>

            <!-- Dirección -->
            <div>
                <label class="text-sm text-slate-500">Dirección</label>
                <p id="view_DSC_DIRECCION" class="text-slate-900 mt-1"></p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Redes Sociales -->
            <div>
                <h4 class="text-sm font-semibold text-slate-900 mb-3">Redes Sociales</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-slate-500">Facebook</label>
                        <p id="view_DSC_FACEBOOK" class="text-slate-900 mt-1"></p>
                    </div>
                    <div>
                        <label class="text-sm text-slate-500">Instagram</label>
                        <p id="view_DSC_INSTAGRAM" class="text-slate-900 mt-1"></p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Coordenadas -->
            <div>
                <h4 class="text-sm font-semibold text-slate-900 mb-3">Ubicación GPS</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-slate-500">Latitud</label>
                        <p id="view_NUM_LATITUD" class="text-slate-900 mt-1"></p>
                    </div>
                    <div>
                        <label class="text-sm text-slate-500">Longitud</label>
                        <p id="view_NUM_LONGITUD" class="text-slate-900 mt-1"></p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Metadata -->
            <div>
                <h4 class="text-sm font-semibold text-slate-900 mb-3">Información del Sistema</h4>
                <div>
                    <label class="text-sm text-slate-500">Fecha de Creación</label>
                    <p id="view_FEC_CREACION" class="text-slate-900 mt-1"></p>
                </div>
            </div>
        </div>

        <!-- Footer del Modal -->
        <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
            
        </div>
    </div>
</div>