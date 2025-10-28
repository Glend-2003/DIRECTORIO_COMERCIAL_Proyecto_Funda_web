@extends('admin.layouts.app')

@section('title', 'Gestión de Sliders')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 mb-1">Gestión de Sliders</h2>
                <p class="text-slate-600">Administra las imágenes del slider principal</p>
            </div>
            <button onclick="openCreateModal()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Slider
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg border">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Imagen</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($sliders as $slider)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $slider->DSC_NOMBRE }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-600">{{ Str::limit($slider->DSC_DESCRIPCION, 50) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($slider->IMG_URL)
                                        <img src="{{ $slider->IMG_URL }}" alt="{{ $slider->DSC_NOMBRE }}"
                                            class="h-10 w-auto object-cover rounded">
                                    @else
                                        <span class="text-slate-400">Sin imagen</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            onclick="openEditModal({
                                            'ID_SLIDER': {{ $slider->ID_SLIDER }},
                                            'DSC_NOMBRE': '{{ addslashes($slider->DSC_NOMBRE) }}',
                                            'DSC_DESCRIPCION': '{{ addslashes($slider->DSC_DESCRIPCION) }}',
                                            'IMG_URL': '{{ addslashes($slider->IMG_URL) }}'
                                        })"
                                            class="px-3 py-1 text-sm text-slate-600 hover:bg-slate-50 rounded">
                                            Editar
                                        </button>

                                        <button
                                            onclick="openViewModal({
                                                'ID_SLIDER': {{ $slider->ID_SLIDER }},
                                                'DSC_NOMBRE': '{{ addslashes($slider->DSC_NOMBRE) }}',
                                                'DSC_DESCRIPCION': '{{ addslashes($slider->DSC_DESCRIPCION) }}',
                                                'IMG_URL': '{{ addslashes($slider->IMG_URL) }}',
                                                'created_at': '{{ $slider->created_at }}'
                                            })"
                                            class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                                            Ver
                                        </button>
                                        <!-- Botón para Eliminar -->
                                        <button
                                            onclick="openDeleteModal({{ $slider->ID_SLIDER }}, '{{ addslashes($slider->DSC_NOMBRE) }}')"
                                            class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    No hay sliders registrados.
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

    <!-- Script de debug adicional -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== DEBUG MODALS ===');

            // Verificar que los modales existen
            const modals = ['createModal', 'editModal', 'viewModal', 'deleteModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                console.log(modalId + ':', modal ? 'ENCONTRADO' : 'NO ENCONTRADO');
            });

            // Verificar que las funciones estén disponibles
            console.log('Funciones disponibles:', {
                openCreateModal: typeof openCreateModal,
                openEditModal: typeof openEditModal,
                openViewModal: typeof openViewModal,
                openDeleteModal: typeof openDeleteModal
            });

            // Test simple - crear un slider de prueba
            window.testSlider = {
                ID_SLIDER: 999,
                DSC_NOMBRE: 'Slider de Prueba',
                DSC_DESCRIPCION: 'Esta es una descripción de prueba',
                IMG_URL: 'https://via.placeholder.com/150',
                created_at: new Date().toISOString()
            };

            console.log('Slider de prueba creado:', window.testSlider);
            console.log('Para probar: openEditModal(testSlider) o openViewModal(testSlider)');
        });
    </script>
@endsection
