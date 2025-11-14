@extends('admin.layouts.app')

@section('title', 'Gestión de Sliders')

@section('content')
    <div class="space-y-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-slate-600 mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            <span class="mx-2 text-slate-400">></span>
            <span class="text-slate-900 font-medium">Sliders</span>
        </nav>

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-1">Gestión de Sliders</h2>
                <p class="text-slate-600">Administra las imágenes del slider principal</p>
            </div>
            <button onclick="openCreateModal()"
                class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Slider
            </button>
        </div>

        <!-- Mensajes de éxito/error -->
        @if (session('success'))
            <div id="successAlert"
                class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="errorAlert"
                class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Card con Tabla -->
        <div class="bg-white rounded-lg border">
            <!-- Buscador -->
            <div class="p-6 border-b">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Buscar sliders..."
                        class="w-full md:w-96 pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50">
                </div>
            </div>

            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">
                                Imagen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">
                                Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">
                                Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">
                                URL Web</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">
                                Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" id="slidersTableBody">
                        @forelse($sliders as $slider)
                            @php
                                $sliderData = [
                                    'ID_SLIDER' => $slider->ID_SLIDER,
                                    'DSC_NOMBRE' => $slider->DSC_NOMBRE,
                                    'DSC_DESCRIPCION' => $slider->DSC_DESCRIPCION,
                                    'IMG_URL' => $slider->IMG_URL,
                                    'NUM_ESTADO' => $slider->NUM_ESTADO,
                                    'URL_WEB' => $slider->URL_WEB,
                                    'created_at' => $slider->created_at,
                                    'updated_at' => $slider->updated_at
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50 slider-row"
                                data-search="{{ strtolower($slider->DSC_NOMBRE . ' ' . $slider->DSC_DESCRIPCION . ' ' . $slider->URL_WEB . ' ' . ($slider->NUM_ESTADO == 1 ? 'activo' : 'inactivo')) }}">
                                <!-- Columna Imagen -->
                                <td class="px-6 py-4">
                                    @if ($slider->IMG_URL)
                                        <img src="{{ $slider->IMG_URL }}" alt="{{ $slider->DSC_NOMBRE }}"
                                            class="h-12 w-16 object-cover rounded-lg border shadow-sm">
                                    @else
                                        <span class="text-slate-400 text-sm">Sin imagen</span>
                                    @endif
                                </td>
                                
                                <!-- Columna Nombre -->
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $slider->DSC_NOMBRE }}</div>
                                </td>
                                
                                <!-- Columna Descripción -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-600 max-w-xs">
                                        @if($slider->DSC_DESCRIPCION)
                                            {{ Str::limit($slider->DSC_DESCRIPCION, 60) }}
                                        @else
                                            <span class="text-slate-400">Sin descripción</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Columna URL Web - NUEVA COLUMNA -->
                                <td class="px-6 py-4">
                                    @if($slider->URL_WEB)
                                        <a href="{{ $slider->URL_WEB }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 hover:underline text-sm break-all max-w-xs inline-block">
                                            {{ Str::limit($slider->URL_WEB, 40) }}
                                        </a>
                                        <br>
                                        <span class="text-xs text-slate-500">Haz clic para visitar</span>
                                    @else
                                        <span class="text-slate-400 text-sm">No especificada</span>
                                    @endif
                                </td>
                                
                                <!-- Columna Estado -->
                                <td class="px-6 py-4">
                                    @if ($slider->NUM_ESTADO == 1)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Activo
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Columna Acciones -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Botón Ver -->
                                        <button type="button"
                                            onclick="openViewModal({{ json_encode($sliderData) }})"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Ver detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <!-- Botón Editar -->
                                        <button type="button"
                                            onclick="openEditModal({{ json_encode($sliderData) }})"
                                            class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                                            title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <button type="button"
                                            onclick="openDeleteModal({{ $slider->ID_SLIDER }}, '{{ addslashes($slider->DSC_NOMBRE) }}')"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500"> <!-- Cambiado a colspan="6" -->
                                    <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mb-2">No hay sliders registrados</p>
                                    <button onclick="openCreateModal()" class="text-blue-600 hover:underline font-medium">
                                        Crear el primero
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Incluir los modales -->
    @include('admin.layouts.modalsSliders.modal')

    <script>
        // Auto-cerrar alertas después de 5 segundos
        setTimeout(() => {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            if (successAlert) successAlert.remove();
            if (errorAlert) errorAlert.remove();
        }, 5000);

        // Funcionalidad de Búsqueda
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('.slider-row');
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
                            switch (modalId) {
                                case 'createModal':
                                    closeCreateModal();
                                    break;
                                case 'editModal':
                                    closeEditModal();
                                    break;
                                case 'viewModal':
                                    closeViewModal();
                                    break;
                                case 'deleteModal':
                                    closeDeleteModal();
                                    break;
                            }
                        }
                    });
                }
            });
        });

        console.log('JavaScript de sliders cargado correctamente');
    </script>
@endsection