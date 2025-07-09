@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Mis Pedidos</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.panel') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al panel</a>
    
    <div class="">
        @if($pedidos->isEmpty())
            <div class="p-8 text-center text-gray-500 bg-white rounded shadow">
                <div class="text-lg mb-2">No tienes pedidos aún</div>
                <a href="{{ route('catalogo') }}" class="bg-[#EAA451] text-white px-6 py-2 rounded hover:bg-orange-500 transition-colors inline-block mt-2">Explorar catálogo</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pedidos as $pedido)
                    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col gap-2 hover:shadow-2xl transition-all duration-200 border border-transparent hover:border-[#EAA451]">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm text-gray-500">Pedido <span class="font-bold text-[#16183E]">#{{ $pedido->id }}</span></div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($pedido->estado == 'completado') bg-green-100 text-green-800
                                @elseif($pedido->estado == 'enviado') bg-blue-100 text-blue-800
                                @elseif($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </div>
                        <div class="text-lg font-bold text-blue-900 mb-1">S/ {{ number_format($pedido->total, 2) }}</div>
                        <div class="text-sm text-gray-700 mb-1 flex items-center gap-2">
                            <img src="{{ asset('icons/date.svg') }}" alt="Fecha" class="w-5 h-5 text-gray-400">
                            {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '-' }}
                        </div>
                        <div class="text-sm text-gray-700 mb-1 flex items-center gap-2">
                            <img src="{{ asset('icons/metodopago.svg') }}" alt="Método de pago" class="w-5 h-5 text-gray-400">
                            {{ ucfirst($pedido->metodo_pago) ?? '-' }}
                        </div>
                        <a href="{{ route('user.pedido.detalle', $pedido->id) }}" class="mt-2 bg-[#EAA451] text-white px-4 py-1 rounded hover:bg-orange-500 transition-colors text-sm font-semibold shadow self-end">Ver detalle</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    @if($pedidos->hasPages())
        <div class="mt-6">
            {{ $pedidos->links() }}
        </div>
    @endif
</div>
@endsection 