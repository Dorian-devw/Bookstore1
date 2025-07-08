@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Gestión de Stock</h1>
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
            <label class="flex items-center gap-2">
                <input type="checkbox" name="bajo" value="1" @if(request('bajo')) checked @endif>
                <span>Solo stock bajo (< 5)</span>
            </label>
            <button class="bg-blue-50 text-blue-800 border border-blue-200 px-6 py-2 rounded-lg hover:bg-blue-100 transition font-semibold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>Filtrar
            </button>
        </form>
        <a href="{{ route('admin.libros.index') }}" class="text-blue-700 hover:underline font-semibold flex items-center gap-2 bg-blue-50 border border-blue-200 px-5 py-2 rounded-lg hover:bg-blue-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 016.5 17H20M4 19.5V6.5A2.5 2.5 0 016.5 4H20v13M4 19.5A2.5 2.5 0 006.5 22H20" />
            </svg> Gestión de libros
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
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actualizar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($libros as $libro)
                    <tr class="hover:bg-gray-50
                        @if($libro->stock == 0)
                            bg-red-50
                        @elseif($libro->stock > 0 && $libro->stock <= 10)
                            bg-yellow-50
                        @endif
                    ">
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
                            <form action="{{ route('admin.stock.update', $libro->id) }}" method="POST" class="flex gap-2 items-center">
                                @csrf
                                <input type="number" name="stock" value="{{ $libro->stock }}" min="0" 
                                       class="w-20 border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button type="submit" 
                                        class="inline-flex items-center gap-2 bg-blue-50 text-blue-800 border border-blue-200 px-3 py-1.5 rounded-lg shadow hover:bg-blue-100 transition font-semibold text-xs">
                                    🔄 Actualizar
                                </button>
                            </form>
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