@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Historial de Libros Vistos</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al panel</a>
    
    @if($historial->isEmpty())
        <div class="bg-white rounded shadow p-8 text-center">
            <div class="text-gray-500 mb-4">
                <div class="text-lg mb-2">No has visto libros recientemente</div>
                <p>Tu historial de libros vistos aparecerá aquí.</p>
            </div>
            <a href="{{ route('catalogo') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Explorar catálogo</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($historial as $visto)
                <div class="bg-white rounded shadow p-4">
                    <div class="flex items-start gap-4">
                        <img src="{{ $visto->libro->imagen ? asset($visto->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $visto->libro->titulo }}" class="w-20 h-28 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg mb-1">{{ $visto->libro->titulo }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $visto->libro->autor->nombre ?? '' }}</p>
                            <p class="text-gray-500 text-sm mb-2">{{ $visto->libro->categoria->nombre ?? '' }}</p>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-yellow-400 font-bold">{{ number_format($visto->libro->valoracion, 1) }} ★</span>
                                <span class="text-blue-700 font-bold">S/ {{ number_format($visto->libro->precio, 2) }}</span>
                            </div>
                            <div class="text-xs text-gray-500 mb-2">
                                Visto el {{ \Carbon\Carbon::parse($visto->visto_en)->format('d/m/Y H:i') }}
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('libro.detalle', $visto->libro->id) }}" class="text-blue-600 hover:underline text-sm">Ver detalle</a>
                                <form action="{{ route('user.favoritos.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="libro_id" value="{{ $visto->libro->id }}">
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Agregar a favoritos</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($historial->hasPages())
            <div class="mt-8">
                {{ $historial->links() }}
            </div>
        @endif
    @endif
</div>
@endsection 