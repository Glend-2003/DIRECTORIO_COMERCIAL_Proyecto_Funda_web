@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 mb-1">Panel de Control</h2>
        <p class="text-slate-600">Resumen general del sistema</p>
    </div>

    <!-- Stats -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg border p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-slate-600">Total Comercios Activos</span>
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-slate-900">{{ $totalComercios }}</div>
            <div class="text-sm text-green-600">Activos</div>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-slate-600">Total Productos</span>
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-slate-900">0</div>
            <div class="text-sm text-slate-600">Próximamente</div>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-slate-600">Categorías</span>
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-slate-900">0</div>
            <div class="text-sm text-slate-600">Próximamente</div>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-slate-600">Visitas Hoy</span>
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="text-3xl font-bold text-slate-900">0</div>
            <div class="text-sm text-slate-600">Próximamente</div>
        </div>
    </div>

    <!-- Recent Businesses -->
    <div class="bg-white rounded-lg border">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Comercios Activos Recientes</h3>
            <a href="{{ route('comercios.index') }}" class="text-sm text-blue-600 hover:underline">
                Ver Todos
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($comerciosRecientes as $comercio)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-sm text-slate-900">
                            {{ $comercio->DSC_COMERCIO ?? 'Sin nombre' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $comercio->NUM_TELEFONO ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $comercio->DSC_CORREO ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $comercio->FEC_CREACION ? $comercio->FEC_CREACION->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('comercios.show', $comercio->ID_COMERCIO) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                Ver
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            No hay comercios activos
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection