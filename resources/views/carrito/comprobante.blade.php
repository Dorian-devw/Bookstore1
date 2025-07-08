@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-green-600 mb-2">¡Pedido Confirmado!</h1>
                <p class="text-gray-600">Tu pedido ha sido procesado exitosamente</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Información del pedido -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Detalles del Pedido</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium">Número de pedido:</span>
                            <span class="text-gray-600">#{{ $pedido->id }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Fecha:</span>
                            <span class="text-gray-600">{{ $pedido->fecha->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Estado:</span>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">{{ ucfirst($pedido->estado) }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Método de pago:</span>
                            <span class="text-gray-600">{{ ucfirst($pedido->metodo_pago) }}</span>
                        </div>
                        @if($pedido->descuento > 0)
                        <div>
                            <span class="font-medium">Descuento:</span>
                            <span class="text-green-600">-S/ {{ number_format($pedido->descuento, 2) }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="font-medium">Total:</span>
                            <span class="text-xl font-bold text-blue-600">S/ {{ number_format($pedido->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Información del cliente -->
                <div>
                    <h2 class="text-xl font-semibold mb-4">Información de Contacto</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium">Nombre:</span>
                            <span class="text-gray-600">{{ $pedido->cliente_nombre }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Email:</span>
                            <span class="text-gray-600">{{ $pedido->cliente_email }}</span>
                        </div>
                        @if($pedido->cliente_telefono)
                        <div>
                            <span class="font-medium">Teléfono:</span>
                            <span class="text-gray-600">{{ $pedido->cliente_telefono }}</span>
                        </div>
                        @endif
                        @if($pedido->direccion_entrega)
                        <div>
                            <span class="font-medium">Dirección de entrega:</span>
                            <span class="text-gray-600">{{ $pedido->direccion_entrega }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Productos -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Productos</h2>
                <div class="space-y-4">
                    @foreach($pedido->detalles as $detalle)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded">
                        <img src="{{ $detalle->libro->imagen ? asset($detalle->libro->imagen) : asset('images/default-book.png') }}" 
                             alt="{{ $detalle->libro->titulo }}" 
                             class="w-16 h-20 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-semibold">{{ $detalle->libro->titulo }}</h3>
                            <p class="text-sm text-gray-600">{{ $detalle->libro->autor->nombre ?? '' }}</p>
                            <p class="text-sm text-gray-500">Cantidad: {{ $detalle->cantidad }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Mensajes importantes -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2">Información importante:</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Recibirás un email de confirmación en {{ $pedido->cliente_email }}</li>
                    <li>• El pedido será procesado en las próximas 24 horas</li>
                    <li>• Te contactaremos para coordinar la entrega</li>
                    <li>• Guarda este número de pedido: <strong>#{{ $pedido->id }}</strong></li>
                </ul>
            </div>

            <!-- Botones de acción -->
            <div class="mt-8 text-center space-x-4">
                <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Volver al inicio
                </a>
                <a href="{{ route('catalogo') }}" class="inline-block bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                    Seguir comprando
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 