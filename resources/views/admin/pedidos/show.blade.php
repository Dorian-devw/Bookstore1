@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Detalle del Pedido #{{ $pedido->id }}</h1>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.pedidos.index') }}" class="text-blue-700 hover:underline font-semibold">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>Volver a pedidos
        </a>
        
        <!-- Botón de descargar PDF -->
        @if($pedido->estado == 'completado')
            <a href="{{ route('admin.pedidos.comprobante', $pedido->id) }}" 
               class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg shadow hover:bg-green-700 transition font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>Descargar Comprobante PDF
            </a>
        @else
            <button disabled 
                    class="inline-flex items-center gap-2 bg-gray-300 text-gray-500 px-6 py-3 rounded-lg cursor-not-allowed font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>Descargar Comprobante PDF
            </button>
        @endif
    </div>

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
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $detalle->libro->titulo ?? '-' }}</td>
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
            <div>
                <form action="{{ route('admin.pedidos.estado', $pedido->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cambiar estado del pedido:</label>
                        <select name="estado" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pendiente" @if($pedido->estado=='pendiente') selected @endif>Pendiente</option>
                            <option value="enviado" @if($pedido->estado=='enviado') selected @endif>Enviado</option>
                            <option value="completado" @if($pedido->estado=='completado') selected @endif>Completado</option>
                            <option value="cancelado" @if($pedido->estado=='cancelado') selected @endif>Cancelado</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>Actualizar Estado
                    </button>
                </form>
            </div>
        </div>
        @if($pedido->estado != 'completado')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <span class="text-yellow-800 font-medium">El comprobante PDF solo estará disponible cuando el pedido esté completado.</span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 