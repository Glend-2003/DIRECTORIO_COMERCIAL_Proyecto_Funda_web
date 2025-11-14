@extends('admin.layouts.app')

@section('title', 'Editar Slider')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 mb-1">Editar Slider</h2>
        <p class="text-slate-600">Modifica los datos del slider</p>
    </div>

    <div class="bg-white rounded-lg border p-6">
        <!-- Tu formulario tradicional para editar -->
        <form action="{{ route('sliders.update', $slider->ID_SLIDER) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- ... resto del formulario ... -->
        </form>
    </div>
</div>

<!-- Incluir modal de eliminar -->
@include('admin.layouts.modalsSliders.modal')
@endsection