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
            <a href="{{ route('catalogo') }}" class="bg-[#EAA451] text-white px-6 py-2 rounded hover:bg-orange-500 transition-colors">Explorar catálogo</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($favoritos as $favorito)
                <div class="relative bg-white rounded-2xl shadow-lg p-4 flex flex-col items-center group transition-all duration-200 hover:shadow-2xl hover:ring-2 hover:ring-[#EAA451]">
                    <!-- Botón eliminar favorito -->
                    <form action="{{ route('user.favoritos.destroy', $favorito->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-white shadow border border-gray-200 hover:bg-red-50 hover:border-red-300 transition" title="Eliminar de favoritos" onclick="return confirm('¿Eliminar de favoritos?')">
                            <img src="{{ asset('icons/equis.svg') }}" alt="Eliminar favorito" class="w-5 h-5 text-red-500">
                        </button>
                    </form>
                    <a href="{{ route('libro.detalle', $favorito->libro->id) }}" class="block w-full flex justify-center mb-3">
                        <img src="{{ $favorito->libro->imagen ? asset($favorito->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $favorito->libro->titulo }}" class="w-28 h-40 object-cover rounded-lg shadow group-hover:scale-105 transition-transform duration-200">
                    </a>
                    <div class="flex-1 w-full flex flex-col items-center justify-between">
                        <div class="font-semibold text-center text-[#16183E] line-clamp-2 min-h-[48px] mb-1">{{ $favorito->libro->titulo }}</div>
                        <div class="text-sm text-gray-500 mb-1">{{ $favorito->libro->autor->nombre ?? '' }}</div>
                        <div class="flex items-center gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <img src="{{ asset('icons/star.svg') }}" 
                                     alt="Estrella" 
                                     class="w-4 h-4 {{ $i <= $favorito->libro->valoracion ? 'text-yellow-400' : 'text-gray-300' }}"
                                     style="filter: {{ $i <= $favorito->libro->valoracion ? 'brightness(1) saturate(1)' : 'brightness(0.3) saturate(0)' }}">
                            @endfor
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($favorito->libro->valoracion, 1) }})</span>
                        </div>
                        <div class="text-blue-900 font-bold text-lg mb-2">S/ {{ number_format($favorito->libro->precio, 2) }}</div>
                        <a href="{{ route('libro.detalle', $favorito->libro->id) }}" class="mt-2 bg-[#EAA451] text-white px-4 py-1 rounded hover:bg-orange-500 transition-colors text-sm font-semibold shadow">Ver detalle</a>
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