@extends('admin.layouts.app')

@section('title', 'Crear Slider')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 mb-1">Crear Nuevo Slider</h2>
        <p class="text-slate-600">Complete los datos del slider</p>
    </div>

    <div class="bg-white rounded-lg border p-6">
        <!-- Tu formulario tradicional para crear -->
        <form action="{{ route('sliders.store') }}" method="POST">
            @csrf
            <!-- ... resto del formulario ... -->
        </form>
    </div>
</div>

<!-- Incluir modal de eliminar si lo necesitas -->
@include('admin.layouts.modalsSliders.modal')
@endsection