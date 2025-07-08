@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Detalle del Pedido #{{ $pedido->id }}</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.pedidos') }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver a mis pedidos</a>
    
    <!-- Información del pedido -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Información del pedido</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="mb-2"><span class="font-semibold">Número de pedido:</span> #{{ $pedido->id }}</div>
                <div class="mb-2"><span class="font-semibold">Fecha:</span> {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '-' }}</div>
                <div class="mb-2"><span class="font-semibold">Método de pago:</span> {{ ucfirst($pedido->metodo_pago) }}</div>
            </div>
            <div>
                <div class="mb-2"><span class="font-semibold">Estado:</span> 
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($pedido->estado == 'completado') bg-green-100 text-green-800
                        @elseif($pedido->estado == 'enviado') bg-blue-100 text-blue-800
                        @elseif($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </div>
                <div class="mb-2"><span class="font-semibold">Estado del pago:</span> {{ $pedido->pago->estado ?? 'pendiente' }}</div>
                <div class="mb-2"><span class="font-semibold">Total:</span> <span class="text-xl font-bold text-blue-600">S/ {{ number_format($pedido->total, 2) }}</span></div>
            </div>
        </div>
    </div>

    <!-- Libros comprados -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Libros comprados</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Libro</th>
                        <th class="px-4 py-2 text-left">Cantidad</th>
                        <th class="px-4 py-2 text-left">Precio unitario</th>
                        <th class="px-4 py-2 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pedido->detalles as $detalle)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $detalle->libro->imagen ? asset($detalle->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $detalle->libro->titulo }}" class="w-12 h-16 object-cover rounded">
                                    <div>
                                        <div class="font-semibold">{{ $detalle->libro->titulo }}</div>
                                        <div class="text-sm text-gray-600">{{ $detalle->libro->autor->nombre ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $detalle->cantidad }}</td>
                            <td class="px-4 py-3">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="px-4 py-3 font-semibold">S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right">
            <div class="text-xl font-bold">Total: S/ {{ number_format($pedido->total, 2) }}</div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Información adicional</h2>
        <div class="text-gray-600 mb-4">
            <p>Si tienes alguna pregunta sobre tu pedido, puedes contactarnos a través de nuestro servicio al cliente.</p>
            <p class="mt-2">Gracias por tu compra en Flying Bookstore.</p>
        </div>
        <a href="{{ route('user.pedido.comprobante', $pedido->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Descargar comprobante PDF</a>
    </div>
</div>
@endsection 