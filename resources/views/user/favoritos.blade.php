@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Mis Favoritos</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al panel</a>
    
    @if($favoritos->isEmpty())
        <div class="bg-white rounded shadow p-8 text-center">
            <div class="text-gray-500 mb-4">
                <div class="text-lg mb-2">No tienes libros favoritos</div>
                <p>Agrega libros a tus favoritos para encontrarlos fácilmente más tarde.</p>
            </div>
            <a href="{{ route('catalogo') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Explorar catálogo</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favoritos as $favorito)
                <div class="bg-white rounded shadow p-4">
                    <div class="flex items-start gap-4">
                        <img src="{{ $favorito->libro->imagen ? asset($favorito->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $favorito->libro->titulo }}" class="w-20 h-28 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg mb-1">{{ $favorito->libro->titulo }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $favorito->libro->autor->nombre ?? '' }}</p>
                            <p class="text-gray-500 text-sm mb-2">{{ $favorito->libro->categoria->nombre ?? '' }}</p>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-yellow-400 font-bold">{{ number_format($favorito->libro->valoracion, 1) }} ★</span>
                                <span class="text-blue-700 font-bold">S/ {{ number_format($favorito->libro->precio, 2) }}</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('libro.detalle', $favorito->libro->id) }}" class="text-blue-600 hover:underline text-sm">Ver detalle</a>
                                <form action="{{ route('user.favoritos.destroy', $favorito->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('¿Eliminar de favoritos?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($favoritos->hasPages())
            <div class="mt-8">
                {{ $favoritos->links() }}
            </div>
        @endif
    @endif
</div>
@endsection 