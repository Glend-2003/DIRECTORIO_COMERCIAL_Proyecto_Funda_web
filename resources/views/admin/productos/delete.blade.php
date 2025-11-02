{{-- Modal de Confirmación de Eliminación --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 text-center mb-2">¿Eliminar Producto?</h3>
            <p class="text-sm text-slate-600 text-center mb-6">
                Esta acción no se puede deshacer. El Producto será eliminado permanentemente.
            </p>
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg hover:bg-slate-50 font-medium">
                    Cancelar
                </button>
                <button type="button" 
                        id="confirmDeleteBtn"
                        onclick="executeDelete()"
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>