@php
    // Determinar el tipo de operación y la ruta
    $isView = $tipo === 'view';
    $isEdit = $tipo === 'edit';
    $isCreate = $tipo === 'create';
    
    $modalId = $isView ? 'viewModal' : ($isEdit ? 'editModal' : 'createModal');
    $modalTitle = $isView ? 'Detalles de la Categoría' : ($isEdit ? 'Editar Categoría' : 'Agregar Nueva Categoría');
    $buttonText = $isEdit ? 'Actualizar Categoría' : 'Guardar Categoría';
    
 
    // ES EL JS SE HACE LA LOGICA PARA MOSTRAR LOS MODALES PRROS
    $ruta = $isEdit ? '#' : route('categorias.store');
@endphp

<!-- Modal CREAR/EDITAR/VER -->
<div id="{{ $modalId }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <form action="{{ $ruta }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            
            <!-- Header del Modal -->
            <div class="flex items-center justify-between p-6 border-b sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-slate-900">{{ $modalTitle }}</h3>
                <button type="button" 
                        onclick="close{{ ucfirst($tipo) }}Modal()" 
                        class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <!-- Nombre de la categoría -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre de la Categoría *
                    </label>
                    <input type="text" 
                           name="DSC_NOMBRE" 
                           placeholder="Nombre"
                           value="{{ isset($categoria->DSC_NOMBRE) ? $categoria->DSC_NOMBRE : '' }}"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                           {{ $isView ? 'readonly' : 'required' }}>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="DSC_DESCRIPCION" 
                              rows="3"
                              placeholder="Descripción de la categoría"
                              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                              {{ $isView ? 'readonly' : '' }}>{{ isset($categoria->DSC_DESCRIPCION) ? $categoria->DSC_DESCRIPCION : '' }}</textarea>
                </div>

                <!-- Imagen Destacada -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Imagen Categoría
                    </label>
                    
                    @if($isView || $isEdit)
                        <!-- Contenedor para mostrar imagen actual -->
                        <div id="imagen-preview-{{ $modalId }}" class="mb-3 hidden">
                            <img src="" 
                                 alt="Imagen de categoría" 
                                 class="w-32 h-32 rounded-lg object-cover border border-slate-200">
                        </div>
                    @endif
                    
                    @if(!$isView)
                        <input type="file" 
                               name="IMG_URL" 
                               accept="image/*"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        @if($isEdit)
                            <p class="text-xs text-slate-500 mt-1">Deja en blanco si no deseas cambiar la imagen</p>
                        @endif
                    @endif
                </div>

                <!-- Estado (solo en editar y ver) -->
                @if($isEdit || $isView)
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Estado
                        </label>
                        <select name="NUM_ESTADO" 
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                                {{ $isView ? 'disabled' : '' }}>
                            <option value="1" {{ (isset($categoria->NUM_ESTADO) && $categoria->NUM_ESTADO == 1) ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="0" {{ (isset($categoria->NUM_ESTADO) && $categoria->NUM_ESTADO == 0) ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>
                @endif

                <!-- Información adicional (solo en ver y editar) -->
                @if(($isView || $isEdit) && isset($categoria->FEC_CREACION))
                    <div class="pt-4 border-t">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-500">Fecha de creación:</span>
                                <p class="font-medium text-slate-900">{{ $categoria->FEC_CREACION->format('d/m/Y H:i') }}</p>
                            </div>
                            @if(isset($categoria->FEC_ACTUALIZACION))
                                <div>
                                    <span class="text-slate-500">Última actualización:</span>
                                    <p class="font-medium text-slate-900">{{ $categoria->FEC_ACTUALIZACION->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer del Modal -->
            <div class="flex items-center justify-end gap-3 p-6 border-t bg-slate-50 sticky bottom-0">
                <button type="button" 
                        onclick="close{{ ucfirst($tipo) }}Modal()"
                        class="px-6 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-medium">
                    {{ $isView ? 'Cerrar' : 'Cancelar' }}
                </button>
                
                @if(!$isView)
                    <button type="submit" 
                            class="px-6 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                        {{ $buttonText }}
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>