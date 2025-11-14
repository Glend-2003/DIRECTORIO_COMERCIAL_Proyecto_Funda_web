@extends('admin.layouts.app')

@section('title', 'Detalle del Slider')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Detalle del Slider</h2>
            <p class="text-slate-600">Información completa del slider</p>
        </div>
        <div class="flex gap-2">
            <button onclick="openEditModal(@json($slider))"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Editar (Modal)
            </button>
            <button onclick="openDeleteModal({{ $slider->ID_SLIDER }}, '{{ $slider->DSC_NOMBRE }}')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Eliminar
            </button>
        </div>
    </div>

    <!-- Contenido de show -->
    <div class="bg-white rounded-lg border p-6">
        <!-- ... contenido del show ... -->
    </div>
</div>

<!-- Incluir modales -->
@include('admin.layouts.modalsSliders.modal')
@endsection