@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Detalle del Pedido #{{ $pedido->id }}</h1>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('user.pedidos') }}" class="text-blue-700 hover:underline font-semibold mb-6 inline-block">
        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>Volver a mis pedidos
    </a>

    <!-- Información del cliente -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Información del Cliente</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="mb-2"><span class="font-semibold text-gray-700">Nombre:</span> <span class="text-gray-900">{{ $pedido->user->name ?? '-' }}</span></div>
                <div class="mb-2"><span class="font-semibold text-gray-700">Correo:</span> <span class="text-gray-900">{{ $pedido->user->email ?? '-' }}</span></div>
                <div class="mb-2"><span class="font-semibold text-gray-700">Dirección de entrega:</span> <span class="text-gray-900">{{ $pedido->direccion_entrega ?? '-' }}</span></div>
            </div>
            <div>
                <div class="mb-2"><span class="font-semibold text-gray-700">Fecha del pedido:</span> <span class="text-gray-900">{{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '-' }}</span></div>
                <div class="mb-2"><span class="font-semibold text-gray-700">Fecha de entrega:</span> <span class="text-gray-900">{{ $pedido->fecha_entrega ? \Carbon\Carbon::parse($pedido->fecha_entrega)->format('d/m/Y') : '-' }}</span></div>
                <div class="mb-2"><span class="font-semibold text-gray-700">Método de pago:</span> <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($pedido->metodo_pago) }}</span></div>
            </div>
        </div>
    </div>

    <!-- Libros comprados -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Libros Comprados</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Libro</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Cantidad</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Precio unitario</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pedido->detalles as $detalle)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900 flex items-center gap-3">
                                <img src="{{ $detalle->libro->imagen ? asset($detalle->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $detalle->libro->titulo }}" class="w-12 h-16 object-cover rounded">
                                <div>
                                    <div class="font-semibold">{{ $detalle->libro->titulo }}</div>
                                    <div class="text-sm text-gray-600">{{ $detalle->libro->autor->nombre ?? '' }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-900">{{ $detalle->cantidad }}</td>
                            <td class="px-4 py-3 text-gray-900">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td class="px-4 py-3 font-semibold text-blue-700">S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-right">
            <div class="text-base text-gray-700 mb-1">Costo de envío: <span class="font-semibold">S/ 15.00</span></div>
            <div class="text-2xl font-bold text-blue-700">Total: S/ {{ number_format($pedido->total, 2) }}</div>
        </div>
    </div>

    <!-- Estado del pedido -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Estado del pedido</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <div class="mb-3">
                    <span class="font-semibold text-gray-700">Estado del pedido:</span>
                    <div class="mt-1">
                        @if($pedido->estado == 'completado')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>Completado
                            </span>
                        @elseif($pedido->estado == 'enviado')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                                </svg>Enviado
                            </span>
                        @elseif($pedido->estado == 'pendiente')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                </svg>Pendiente
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>Cancelado
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('user.pedido.comprobante', $pedido->id) }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700 transition font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>Descargar Comprobante PDF
            </a>
        </div>
    </div>
</div>
@endsection 