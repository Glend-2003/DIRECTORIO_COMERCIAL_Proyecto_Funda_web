@extends('admin.layouts.app')

@section('title', 'Gestión de Comercios')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-1">Gestión de Comercios</h2>
            <p class="text-slate-600">Administra todos los comercios del directorio</p>
        </div>
        <a href="{{ route('comercios.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Comercio
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Comercio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Dirección</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($comercios as $comercio)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $comercio->DSC_COMERCIO ?? 'Sin nombre' }}</div>
                            <div class="text-xs text-slate-500">{{ $comercio->FEC_CREACION ? $comercio->FEC_CREACION->format('d/m/Y') : 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">{{ $comercio->NUM_TELEFONO ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $comercio->DSC_CORREO ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ Str::limit($comercio->DSC_DIRECCION ?? '-', 50) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('comercios.show', $comercio->ID_COMERCIO) }}" 
                                   class="px-3 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">
                                    Ver
                                </a>
                                <a href="{{ route('comercios.edit', $comercio->ID_COMERCIO) }}" 
                                   class="px-3 py-1 text-sm text-slate-600 hover:bg-slate-50 rounded">
                                    Editar
                                </a>
                                <form action="{{ route('comercios.destroy', $comercio->ID_COMERCIO) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('¿Eliminar este comercio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm text-red-600 hover:bg-red-50 rounded">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            No hay comercios registrados.
                            <a href="{{ route('comercios.create') }}" class="text-blue-600 hover:underline">
                                Crear el primero
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection