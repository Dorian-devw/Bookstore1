@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Mis Direcciones</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al panel</a>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Formulario para agregar dirección -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Agregar nueva dirección</h2>
            <form action="{{ route('user.direcciones.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-semibold mb-1">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full border rounded p-2" required>
                    @error('direccion')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block font-semibold mb-1">Ciudad</label>
                        <input type="text" name="ciudad" value="{{ old('ciudad') }}" class="w-full border rounded p-2" required>
                        @error('ciudad')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="w-1/2">
                        <label class="block font-semibold mb-1">Departamento</label>
                        <input type="text" name="departamento" value="{{ old('departamento') }}" class="w-full border rounded p-2" required>
                        @error('departamento')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Referencia (opcional)</label>
                    <input type="text" name="referencia" value="{{ old('referencia') }}" class="w-full border rounded p-2">
                    @error('referencia')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full border rounded p-2" required>
                    @error('telefono')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                </div>
                <div class="pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Agregar dirección</button>
                </div>
            </form>
        </div>

        <!-- Listado de direcciones -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Mis direcciones</h2>
            @if($direcciones->isEmpty())
                <div class="text-gray-500">No tienes direcciones guardadas.</div>
            @else
                <div class="space-y-4">
                    @foreach($direcciones as $direccion)
                        <div class="border rounded p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="font-semibold">{{ $direccion->direccion }}</div>
                                    <div class="text-gray-600">{{ $direccion->ciudad }}, {{ $direccion->departamento }}</div>
                                    @if($direccion->referencia)
                                        <div class="text-sm text-gray-500">Ref: {{ $direccion->referencia }}</div>
                                    @endif
                                    <div class="text-sm text-gray-500">{{ $direccion->telefono }}</div>
                                </div>
                                <form action="{{ route('user.direcciones.destroy', $direccion->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('¿Estás seguro de eliminar esta dirección?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 