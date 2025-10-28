@extends('admin.layouts.app')

@section('title', 'Editar Comercio')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900 mb-1">Editar Comercio</h2>
        <p class="text-slate-600">Modifica los datos del comercio</p>
    </div>

    <div class="bg-white rounded-lg border p-6">
        <form action="{{ route('comercios.update', $comercio->ID_COMERCIO) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nombre del Comercio *
                    </label>
                    <input type="text" 
                           name="DSC_COMERCIO" 
                           value="{{ old('DSC_COMERCIO', $comercio->DSC_COMERCIO) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('DSC_COMERCIO') border-red-500 @enderror"
                           required>
                    @error('DSC_COMERCIO')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Teléfono
                    </label>
                    <input type="text" 
                           name="NUM_TELEFONO" 
                           value="{{ old('NUM_TELEFONO', $comercio->NUM_TELEFONO) }}"
                           placeholder="+506 2222-3333"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('NUM_TELEFONO') border-red-500 @enderror">
                    @error('NUM_TELEFONO')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           name="DSC_CORREO" 
                           value="{{ old('DSC_CORREO', $comercio->DSC_CORREO) }}"
                           placeholder="info@comercio.com"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('DSC_CORREO') border-red-500 @enderror">
                    @error('DSC_CORREO')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Dirección
                    </label>
                    <textarea name="DSC_DIRECCION" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('DSC_DIRECCION') border-red-500 @enderror">{{ old('DSC_DIRECCION', $comercio->DSC_DIRECCION) }}</textarea>
                    @error('DSC_DIRECCION')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instagram -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Instagram
                    </label>
                    <input type="text" 
                           name="DSC_INSTAGRAM" 
                           value="{{ old('DSC_INSTAGRAM', $comercio->DSC_INSTAGRAM) }}"
                           placeholder="@comercio"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Facebook -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Facebook
                    </label>
                    <input type="text" 
                           name="DSC_FACEBOOK" 
                           value="{{ old('DSC_FACEBOOK', $comercio->DSC_FACEBOOK) }}"
                           placeholder="facebook.com/comercio"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 mt-6">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Actualizar Comercio
                </button>
                <a href="{{ route('comercios.index') }}" 
                   class="px-6 py-2 border rounded-lg hover:bg-slate-50">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection