@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Crear nuevo libro</h1>
    <form action="{{ route('admin.libros.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        <div>
            <label class="block font-semibold mb-1">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo') }}" class="w-full border rounded p-2" required>
            @error('titulo')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Descripción</label>
            <textarea name="descripcion" class="w-full border rounded p-2">{{ old('descripcion') }}</textarea>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label class="block font-semibold mb-1">Precio</label>
                <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" class="w-full border rounded p-2" required>
                @error('precio')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="w-1/2">
                <label class="block font-semibold mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border rounded p-2" required>
                @error('stock')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div>
            <label class="block font-semibold mb-1">Imagen (portada)</label>
            <input type="file" name="imagen" class="w-full border rounded p-2">
            @error('imagen')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label class="block font-semibold mb-1">Categoría</label>
                <select name="categoria_id" class="w-full border rounded p-2" required>
                    <option value="">Selecciona</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @if(old('categoria_id') == $cat->id) selected @endif>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                @error('categoria_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="w-1/2">
                <label class="block font-semibold mb-1">Autor</label>
                <select name="autor_id" class="w-full border rounded p-2" required>
                    <option value="">Selecciona</option>
                    @foreach($autores as $autor)
                        <option value="{{ $autor->id }}" @if(old('autor_id') == $autor->id) selected @endif>{{ $autor->nombre }}</option>
                    @endforeach
                </select>
                @error('autor_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label class="block font-semibold mb-1">Idioma</label>
                <input type="text" name="idioma" value="{{ old('idioma') }}" class="w-full border rounded p-2" required>
                @error('idioma')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="w-1/2">
                <label class="block font-semibold mb-1">Valoración</label>
                <input type="number" step="0.1" min="0" max="5" name="valoracion" value="{{ old('valoracion') }}" class="w-full border rounded p-2">
                @error('valoracion')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
        </div>
        <div>
            <label class="block font-semibold mb-1">Fecha de publicación</label>
            <input type="date" name="publicado_en" value="{{ old('publicado_en') }}" class="w-full border rounded p-2">
        </div>
        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded hover:bg-blue-700">Crear libro</button>
            <a href="{{ route('admin.libros.index') }}" class="ml-4 text-blue-700 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection 