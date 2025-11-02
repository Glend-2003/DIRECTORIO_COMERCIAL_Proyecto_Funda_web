@php
    // Determinar el tipo de operación y la ruta
    $isView = $tipo === 'view';
    $isEdit = $tipo === 'edit';
    $isCreate = $tipo === 'create';
    
    $modalId = $isView ? 'viewModal' : ($isEdit ? 'editModal' : 'createModal');
    $formId = $isView ? 'formView' : ($isEdit ? 'formEdit' : 'formCreate');
    $modalTitle = $isView ? 'Detalles del Producto' : ($isEdit ? 'Editar Producto' : 'Agregar Nuevo Producto');
    $buttonText = $isEdit ? 'Actualizar Producto' : 'Guardar Producto';
    
    $ruta = $isEdit ? '#' : route('productos.store');
@endphp

<!-- Modal CREAR/EDITAR/VER -->
<div id="{{ $modalId }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <form id="{{ $formId }}" action="{{ $ruta }}" method="POST" enctype="multipart/form-data">
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

            <!-- Contenedor de Alertas -->
            <div id="modalAlert{{ ucfirst($tipo) }}" class="hidden mx-6 mt-4"></div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <!-- Nombre del producto -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Producto *
                    </label>
                    <input type="text" 
                           name="DSC_NOMBRE" 
                           placeholder="Nombre del producto"
                           value="{{ isset($producto->DSC_NOMBRE) ? $producto->DSC_NOMBRE : '' }}"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                           {{ $isView ? 'readonly' : 'required' }}>
                </div>

                <!-- Comercio -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Comercio *
                    </label>
                    @if(isset($comercios) && count($comercios) > 0)
                        <select name="ID_COMERCIO" 
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                                {{ $isView ? 'disabled' : 'required' }}>
                            <option value="">-- Selecciona un comercio --</option>
                            @foreach($comercios as $comercio)
                                <option value="{{ $comercio->ID_COMERCIO }}" 
                                    {{ old('ID_COMERCIO', isset($producto->ID_COMERCIO) ? $producto->ID_COMERCIO : '') == $comercio->ID_COMERCIO ? 'selected' : '' }}>
                                    {{ $comercio->DSC_COMERCIO }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-slate-500">No hay comercios disponibles</p>
                    @endif
                    <p class="mt-1 text-xs text-slate-500">Selecciona el comercio al que pertenece este producto</p>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="DSC_PRODUCTO" 
                              rows="3"
                              placeholder="Descripción del producto (opcional)"
                              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                              {{ $isView ? 'readonly' : '' }}>{{ isset($producto->DSC_PRODUCTO) ? $producto->DSC_PRODUCTO : '' }}</textarea>
                </div>

                <!-- Precio -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Precio *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-500">₡</span>
                        <input type="number" 
                               name="MONTO_PRECIO" 
                               step="0.01"
                               min="0"
                               placeholder="0.00"
                               value="{{ isset($producto->MONTO_PRECIO) ? $producto->MONTO_PRECIO : '' }}"
                               class="w-full pl-8 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 {{ $isView ? 'bg-slate-50 cursor-not-allowed' : '' }}"
                               {{ $isView ? 'readonly' : 'required' }}>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Ingresa el precio del producto</p>
                </div>

                <!-- Imagen Destacada -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Imagen del Producto
                    </label>
                    
                    @if($isView || $isEdit)
                        <!-- Contenedor para mostrar imagen actual -->
                        <div id="imagen-preview-{{ $modalId }}" class="mb-3 hidden">
                            <img src="" 
                                 alt="Imagen del Producto" 
                                 class="w-32 h-32 rounded-lg object-cover border border-slate-200">
                        </div>
                    @endif
                    
                    @if(!$isView)
                        <input type="file" 
                               name="IMG_IMAGEN_DESTACADA" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        @if($isEdit)
                            <p class="text-xs text-slate-500 mt-1">Deja en blanco si no deseas cambiar la imagen</p>
                        @else
                            <p class="text-xs text-slate-500 mt-1">Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP (máx. 2MB)</p>
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
                            <option value="1" {{ (isset($producto->NUM_ESTADO) && $producto->NUM_ESTADO == 1) ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="0" {{ (isset($producto->NUM_ESTADO) && $producto->NUM_ESTADO == 0) ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>
                @endif

                <!-- Información adicional (solo en ver y editar) -->
                @if(($isView || $isEdit) && isset($producto->FEC_CREACION))
                    <div class="pt-4 border-t">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-500">Fecha de creación:</span>
                                <p class="font-medium text-slate-900">{{ $producto->FEC_CREACION->format('d/m/Y H:i') }}</p>
                            </div>
                            @if(isset($producto->FEC_ACTUALIZACION))
                                <div>
                                    <span class="text-slate-500">Última actualización:</span>
                                    <p class="font-medium text-slate-900">{{ $producto->FEC_ACTUALIZACION->format('d/m/Y H:i') }}</p>
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
                        class="px-6 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-medium transition-colors">
                    {{ $isView ? 'Cerrar' : 'Cancelar' }}
                </button>
                
                @if(!$isView)
                    <button type="submit" 
                            class="px-6 py-2.5 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium transition-colors">
                        {{ $buttonText }}
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>