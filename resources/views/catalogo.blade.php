@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Catálogo de Libros</h1>
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filtros -->
        <form method="GET" class="md:w-1/4 bg-white rounded-lg shadow p-4 mb-6 md:mb-0">
            <h2 class="text-xl font-semibold mb-4">Filtros</h2>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Categoría</label>
                <select name="categoria" class="w-full border rounded p-2">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @if(request('categoria') == $cat->id) selected @endif>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Idioma</label>
                <select name="idioma" class="w-full border rounded p-2">
                    <option value="">Todos</option>
                    @foreach($idiomas as $idioma)
                        <option value="{{ $idioma }}" @if(request('idioma') == $idioma) selected @endif>{{ ucfirst($idioma) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Precio</label>
                <div class="flex gap-2">
                    <input type="number" name="precio_min" placeholder="Mín" value="{{ request('precio_min') }}" class="w-1/2 border rounded p-2">
                    <input type="number" name="precio_max" placeholder="Máx" value="{{ request('precio_max') }}" class="w-1/2 border rounded p-2">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Valoración mínima</label>
                <input type="number" step="0.1" min="0" max="5" name="valoracion" value="{{ request('valoracion') }}" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Filtrar</button>
        </form>

        <!-- Listado de libros -->
        <div class="md:w-3/4">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($libros as $libro)
                    <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
                        <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png') }}" alt="{{ $libro->titulo }}" class="w-24 h-36 object-cover mb-2 rounded">
                        <div class="font-semibold text-center">{{ $libro->titulo }}</div>
                        <div class="text-sm text-gray-500">{{ $libro->autor->nombre ?? '' }}</div>
                        <div class="text-yellow-400 font-bold">{{ number_format($libro->valoracion, 1) }} ★</div>
                        <div class="text-blue-700 font-bold mt-1">S/ {{ number_format($libro->precio, 2) }}</div>
                        <a href="#" class="mt-2 text-blue-600 hover:underline text-sm">Ver más</a>
                    </div>
                @empty
                    <div class="col-span-2 md:col-span-3 text-center text-gray-500">No se encontraron libros con los filtros seleccionados.</div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $libros->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 