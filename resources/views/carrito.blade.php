@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl w-full mx-auto px-8">
        <h1 class="text-3xl font-bold text-center mb-8">Carrito de compras</h1>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Lista de productos -->
            <div class="flex-1">
                @if($carrito->isEmpty())
                    <div class="text-gray-500">Tu carrito está vacío.</div>
                @else
                    <div class="space-y-6">
                        @foreach($carrito as $item)
                        <div class="bg-white rounded-lg shadow p-4 flex flex-col md:flex-row items-center gap-6 border border-gray-200">
                            <img src="{{ $item->libro->imagen ? asset($item->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $item->libro->titulo }}" class="w-28 h-40 object-cover rounded mb-4 md:mb-0">
                            <div class="flex-1 flex flex-col gap-2">
                                <div class="font-bold text-lg">{{ $item->libro->titulo }}</div>
                                <div class="text-gray-500 text-sm mb-2">{{ $item->libro->autor->nombre ?? '' }}</div>
                                <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" class="absolute top-4 right-4 md:static md:ml-auto">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Eliminar">
                                        <img src="{{ asset('icons/trash.svg') }}" alt="Eliminar" class="w-5 h-5">
                                    </button>
                                </form>
                                <div class="flex items-center gap-2 mt-2">
                                    <form action="{{ route('carrito.agregar') }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="libro_id" value="{{ $item->libro->id }}">
                                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-2 py-1 border rounded">-</button>
                                        <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="1" max="{{ $item->libro->stock }}" class="w-12 border rounded text-center">
                                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-2 py-1 border rounded">+</button>
                                        <button type="submit" class="hidden"></button> <!-- Para submit con enter -->
                                    </form>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 items-end min-w-[120px]">
                                <div class="text-gray-500 text-sm">Precio:</div>
                                <div class="font-bold text-lg">S/ {{ number_format($item->libro->precio, 2) }}</div>
                                <div class="text-gray-500 text-sm mt-2">Precio Final:</div>
                                <div class="font-bold text-lg text-[#EAA451]">S/ {{ number_format($item->libro->precio * $item->cantidad, 2) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <!-- Resumen de compra -->
            <div class="w-full md:w-80 flex flex-col gap-6">
                <form action="{{ route('carrito.index') }}" method="GET" class="flex gap-2 mb-2">
                    <input type="text" name="cupon_codigo" placeholder="Ingresar código de descuento" value="{{ request('cupon_codigo') ?? session('cupon_codigo') ?? '' }}" class="flex-1 border rounded px-3 py-2">
                    <button type="submit" class="bg-[#0A2342] text-white px-4 py-2 rounded font-semibold">Aplicar</button>
                </form>
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="font-bold text-lg mb-4">RESUMEN DE COMPRA</div>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span class="line-through text-gray-400" style="{{ ($descuento ?? 0) > 0 ? '' : 'display:none;' }}">S/ {{ number_format($total, 2) }}</span>
                        <span class="{{ ($descuento ?? 0) > 0 ? 'hidden' : '' }}">S/ {{ number_format($total, 2) }}</span>
                    </div>
                    @if(($descuento ?? 0) > 0)
                        <div class="flex justify-between mb-2 text-green-600 text-sm">
                            <span>Descuento</span>
                            <span>- S/ {{ number_format($descuento, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center"><span>Costos de envío</span><span>S/ 15.00</span></div>
                    <div class="flex justify-between font-bold text-lg mt-2">
                        <span>TOTAL</span>
                        <span>S/ {{ number_format($total + 15 - ($descuento ?? 0), 2) }}</span>
                    </div>
                    <a href="{{ route('carrito.confirmar') }}" class="block mt-6 w-full bg-[#EAA451] hover:bg-orange-500 text-white font-semibold py-2 rounded text-center transition">Continuar</a>
                </div>
            </div>
        </div>
        <!-- Información del pedido (opcional, solo si hay datos) -->
        @if(isset($pedidoInfo))
        <div class="mt-10 bg-white rounded-lg shadow p-8 max-w-3xl mx-auto">
            <div class="font-bold text-lg mb-4">Información del pedido</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center gap-2"><!-- SVG usuario --> Cliente <span class="font-semibold ml-2">{{ $pedidoInfo['cliente'] ?? '' }}</span></div>
                <div class="flex items-center gap-2"><!-- SVG teléfono --> Teléfono <span class="font-semibold ml-2">{{ $pedidoInfo['telefono'] ?? '' }}</span></div>
                <div class="flex items-center gap-2"><!-- SVG sobre --> Correo <span class="font-semibold ml-2">{{ $pedidoInfo['correo'] ?? '' }}</span></div>
                <div class="flex items-center gap-2"><!-- SVG casa --> Dirección <span class="font-semibold ml-2">{{ $pedidoInfo['direccion'] ?? '' }}</span></div>
                <div class="flex items-center gap-2"><!-- SVG camión --> Método de recepción <span class="font-semibold ml-2">{{ $pedidoInfo['metodo'] ?? '' }}</span></div>
                <div class="flex items-center gap-2"><!-- SVG calendario --> Fecha de compra <span class="font-semibold ml-2">{{ $pedidoInfo['fecha'] ?? '' }}</span></div>
            </div>
            <div class="mt-4 text-right">
                <a href="#" class="bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow transition">Editar</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 