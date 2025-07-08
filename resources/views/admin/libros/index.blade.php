@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Gestión de Libros</h1>
        <a href="{{ route('admin.panel') }}" class="text-blue-700 hover:underline font-semibold flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>Volver al panel
        </a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <form method="GET" class="flex gap-2">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por título..." class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <button class="bg-blue-50 text-blue-800 border border-blue-200 px-6 py-2 rounded-lg hover:bg-blue-100 transition font-semibold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>Buscar
            </button>
        </form>
        <a href="{{ route('admin.libros.create') }}" class="bg-green-50 text-green-800 border border-green-200 px-6 py-2 rounded-lg hover:bg-green-100 transition font-semibold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg> Nuevo libro
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-2xl shadow-lg">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Portada</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Autor</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Categoría</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Precio</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($libros as $libro)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            @if($libro->imagen)
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $libro->imagen) }}" 
                                         alt="{{ $libro->titulo }}" 
                                         class="w-16 h-20 object-cover rounded shadow-md border border-gray-200"
                                         onerror="this.src='https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen'">
                                </div>
                            @else
                                <div class="w-16 h-20 bg-gray-200 rounded flex items-center justify-center border border-gray-300">
                                    <span class="text-gray-500 text-xs text-center">Sin imagen</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $libro->titulo }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($libro->descripcion, 50) }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $libro->autor->nombre ?? 'Sin autor' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $libro->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-semibold text-green-600">S/ {{ number_format($libro->precio, 2) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($libro->stock > 10)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $libro->stock }}
                                </span>
                            @elseif($libro->stock > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $libro->stock }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Agotado
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.libros.edit', $libro->id) }}" 
                                   class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-800 border border-yellow-200 px-3 py-1.5 rounded-lg shadow hover:bg-yellow-100 transition font-semibold text-xs">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('admin.libros.destroy', $libro->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este libro?');" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center gap-2 bg-red-50 text-red-800 border border-red-200 px-3 py-1.5 rounded-lg shadow hover:bg-red-100 transition font-semibold text-xs">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $libros->withQueryString()->links() }}
    </div>
</div>
@endsection 