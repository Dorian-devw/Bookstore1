@extends('layouts.app')

@section('content')
<div class="bg-[#FCFCF6] min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Barra de pasos -->
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center bg-[#EAA451] text-white font-bold">✓</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Carrito</span>
                </div>
                <div class="w-24 h-1 bg-[#EAA451] rounded"></div>
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center bg-[#EAA451] text-white font-bold">✓</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Pedido</span>
                </div>
                <div class="w-24 h-1 bg-[#EAA451] rounded"></div>
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center bg-[#EAA451] text-white font-bold">✓</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Entrega</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-2xl font-bold text-center text-green-600 mb-6">¡Pedido creado exitosamente!</h2>
            <hr class="mb-6">
            <!-- Resumen de libros -->
            <div class="mb-6">
                @foreach($libros as $item)
                <div class="flex items-center gap-6 mb-4">
                    <img src="{{ asset($item->libro->imagen ?? 'images/default-book.png') }}" alt="{{ $item->libro->titulo }}" class="w-20 h-28 object-cover rounded shadow">
                    <div class="flex-1">
                        <div class="font-bold text-lg">{{ $item->libro->titulo }}</div>
                        <div class="text-gray-500 text-sm mb-1">{{ $item->libro->autor->nombre ?? '' }}</div>
                        <div class="text-gray-600">Cantidad: <span class="font-semibold">{{ $item->cantidad }}</span></div>
                    </div>
                    <div class="text-right">
                        <div class="text-gray-500 text-sm">Precio de venta:</div>
                        <div class="font-bold text-lg">S/ {{ number_format($item->libro->precio, 2) }}</div>
                        <div class="text-gray-500 text-sm mt-2">Subtotal:</div>
                        <div class="font-bold text-lg text-[#EAA451]">S/ {{ number_format($item->libro->precio * $item->cantidad, 2) }}</div>
                    </div>
                </div>
                @endforeach
                @if($cupon)
                <div class="flex justify-end mt-2">
                    <span class="text-green-600 font-semibold">Cupón aplicado: {{ $cupon->codigo }} (-S/ {{ number_format($cupon->descuento, 2) }})</span>
                </div>
                @endif
            </div>
            <hr class="mb-6">
            <!-- Información del pedido -->
            <div class="mb-6">
                <div class="font-bold text-lg mb-4 text-center">Información del pedido</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">receipt_long</span> <span class="font-semibold">Número de pedido:</span> <span class="ml-2">PED-{{ $pedido->id }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">event</span> <span class="font-semibold">Fecha de compra:</span> <span class="ml-2">{{ $pedido->created_at->format('d/m/Y') }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">person</span> <span class="font-semibold">Cliente:</span> <span class="ml-2">{{ $pedido->nombre }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">event_available</span> <span class="font-semibold">Fecha de entrega:</span> <span class="ml-2">{{ $pedido->fecha_entrega ? date('d/m/Y', strtotime($pedido->fecha_entrega)) : '-' }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">location_on</span> <span class="font-semibold">Dirección:</span> <span class="ml-2">{{ $pedido->direccion }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">credit_card</span> <span class="font-semibold">Método de pago:</span> <span class="ml-2">{{ strtoupper($pedido->metodo_pago) }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">phone</span> <span class="font-semibold">Número de teléfono:</span> <span class="ml-2">{{ $pedido->telefono }}</span></div>
                    <div class="flex items-center gap-2"><span class="material-icons text-[#EAA451]">attach_money</span> <span class="font-semibold">Importe total:</span> <span class="ml-2">S/ {{ number_format($pedido->total, 2) }}</span></div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mt-8 justify-center">
                <a href="{{ route('catalogo') }}" class="bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow flex items-center gap-2 w-max"><span class="material-icons">arrow_back</span> Volver al catálogo</a>
                <a href="{{ route('pedido.comprobante', $pedido->id) }}" class="bg-[#0A2342] hover:bg-[#EAA451] text-white font-semibold px-6 py-2 rounded shadow flex items-center gap-2 w-max"><span class="material-icons">download</span> Descargar comprobante</a>
                <a href="{{ route('cliente.pedidos') }}" class="bg-[#0A2342] hover:bg-[#EAA451] text-white font-semibold px-6 py-2 rounded shadow flex items-center gap-2 w-max"><span class="material-icons">list_alt</span> Gestión de pedidos</a>
            </div>
        </div>
    </div>
</div>
<!-- Material Icons CDN -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection 