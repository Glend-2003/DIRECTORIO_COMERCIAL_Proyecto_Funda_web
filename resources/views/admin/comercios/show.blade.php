@extends('admin.layouts.app')

@section('title', 'Detalle del Comercio')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Detalle del Comercio</h2>
            <p class="text-slate-600">Información completa del comercio</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('comercios.edit', $comercio->ID_COMERCIO) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Editar
            </a>
            <a href="{{ route('comercios.index') }}" 
               class="px-4 py-2 border rounded-lg hover:bg-slate-50">
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg border">
        <div class="p-6 space-y-6">
            <!-- Nombre -->
            <div>
                <label class="text-sm font-medium text-slate-500 block mb-1">Nombre del Comercio</label>
                <p class="text-lg text-slate-900">{{ $comercio->DSC_COMERCIO ?? 'Sin nombre' }}</p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Información de Contacto -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Información de Contacto</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Teléfono</label>
                        <p class="text-slate-900">{{ $comercio->NUM_TELEFONO ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Email</label>
                        <p class="text-slate-900">{{ $comercio->DSC_CORREO ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Dirección -->
            <div>
                <label class="text-sm font-medium text-slate-500 block mb-1">Dirección</label>
                <p class="text-slate-900">{{ $comercio->DSC_DIRECCION ?? '-' }}</p>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Redes Sociales -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Redes Sociales</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Instagram</label>
                        @if($comercio->DSC_INSTAGRAM)
                        <a href="{{ $comercio->DSC_INSTAGRAM }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $comercio->DSC_INSTAGRAM }}
                        </a>
                        @else
                        <p class="text-slate-900">-</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Facebook</label>
                        @if($comercio->DSC_FACEBOOK)
                        <a href="{{ $comercio->DSC_FACEBOOK }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $comercio->DSC_FACEBOOK }}
                        </a>
                        @else
                        <p class="text-slate-900">-</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Coordenadas -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Ubicación GPS</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Latitud</label>
                        <p class="text-slate-900">{{ $comercio->NUM_LATITUD ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Longitud</label>
                        <p class="text-slate-900">{{ $comercio->NUM_LONGITUD ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6"></div>

            <!-- Metadata -->
            <div>
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Información del Sistema</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Fecha de Creación</label>
                        <p class="text-slate-900">{{ $comercio->FEC_CREACION ? $comercio->FEC_CREACION->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-500 block mb-1">Última Actualización</label>
                        <p class="text-slate-900">{{ $comercio->FEC_CREACION ? $comercio->FEC_CREACION->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer con botón de eliminar -->
        <div class="border-t p-6 bg-slate-50">
            <form action="{{ route('comercios.destroy', $comercio->ID_COMERCIO) }}" 
                  method="POST" 
                  onsubmit="return confirm('¿Estás seguro de eliminar este comercio? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Eliminar Comercio
                </button>
            </form>
        </div>
    </div>
</div>
@endsection