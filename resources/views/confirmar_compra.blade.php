@extends('layouts.app')

@section('content')
<div class="bg-[#FCFCF6] min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Barra de pasos -->
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center bg-[#EAA451] text-white font-bold">✓</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Complete la información</span>
                </div>
                <div class="w-24 h-1 bg-[#EAA451] rounded"></div>
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center border-2 border-[#EAA451] bg-white text-[#EAA451] font-bold">2</div>
                    <span class="text-xs mt-1 text-[#0A2342]">Crear orden</span>
                </div>
                <div class="w-24 h-1 bg-gray-200 rounded"></div>
                <div class="flex flex-col items-center">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center border-2 border-gray-300 bg-white text-gray-400 font-bold">3</div>
                    <span class="text-xs mt-1 text-gray-400">Entrega</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Columna izquierda: Información editable -->
            <form id="formPedido" action="{{ route('carrito.procesar') }}" method="POST" class="bg-white rounded-lg shadow p-8 flex flex-col gap-8">
                @csrf
                <div>
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Información del pedido</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre y segundo nombre</label>
                            <input type="text" id="inputNombre" name="nombre" value="{{ old('nombre', Auth::user()->name ?? '') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Correo</label>
                            <input type="email" id="inputCorreo" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Dirección</label>
                            <input type="text" id="inputDireccion" name="direccion_completa" value="{{ old('direccion_completa') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Número de teléfono</label>
                            <input type="tel" id="inputTelefono" name="telefono" value="{{ old('telefono', Auth::user()->telefono ?? '') }}" required class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Fecha de entrega</label>
                            <input type="date" id="inputFecha" name="fecha_entrega" value="{{ old('fecha_entrega', date('Y-m-d')) }}" required class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Información para la entrega</h2>
                    <div class="space-y-2 text-sm text-[#0A2342]" id="infoEntrega">
                        <div class="flex items-center gap-2">Cliente <span class="font-semibold ml-2" id="entregaNombre">{{ old('nombre', Auth::user()->name ?? '') }}</span></div>
                        <div class="flex items-center gap-2">Fecha de entrega <span class="font-semibold ml-2" id="entregaFecha">{{ old('fecha_entrega', date('d/m/Y')) }}</span></div>
                        <div class="flex items-center gap-2">Dirección <span class="font-semibold ml-2" id="entregaDireccion">{{ old('direccion_completa') }}</span></div>
                        <div class="flex items-center gap-2">Número de teléfono <span class="font-semibold ml-2" id="entregaTelefono">{{ old('telefono', Auth::user()->telefono ?? '') }}</span></div>
                    </div>
                    <button type="button" onclick="actualizarEntrega()" class="mt-4 bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow flex items-center gap-2 w-max">Actualizar información</button>
                </div>
            </form>
            <!-- Columna derecha: Resumen y métodos de pago -->
            <div class="flex flex-col gap-8">
                <div class="bg-white rounded-lg shadow p-8 mb-4">
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Información de la compra</h2>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between items-center"><span>Cantidad de productos</span><span>{{ $carrito->sum('cantidad') }} unidades</span></div>
                        <div class="flex justify-between items-center"><span>Subtotal</span><span>S/ {{ number_format($total, 2) }}</span></div>
                        @if(($descuento ?? 0) > 0)
                        <div class="flex justify-between items-center text-green-600"><span>Cupón aplicado</span><span>- S/ {{ number_format($descuento, 2) }}</span></div>
                        @endif
                        <div class="flex justify-between items-center"><span>Costos de envío</span><span>S/ 15.00</span></div>
                        <div class="flex justify-between items-center font-bold text-lg mt-2"><span>Cantidad a pagar</span><span>S/ {{ number_format($total + 15 - ($descuento ?? 0), 2) }}</span></div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-8 mb-4">
                    <h2 class="text-xl font-bold mb-4 text-[#0A2342]">Métodos de Pago</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="border-2 border-[#EAA451] rounded-lg p-4 flex flex-col items-center cursor-pointer bg-[#FFF5E9]">
                            <!-- SVG transferencia -->
                            <span class="font-semibold mt-2">Transferencia Bancaria</span>
                        </div>
                        <div class="border-2 border-[#EAA451] rounded-lg p-4 flex flex-col items-center cursor-pointer bg-[#FFF5E9]">
                            <!-- SVG tarjeta -->
                            <span class="font-semibold mt-2">Tarjeta de crédito</span>
                        </div>
                        <div class="border-2 border-[#EAA451] rounded-lg p-4 flex flex-col items-center cursor-pointer bg-[#FFF5E9]">
                            <!-- SVG yape -->
                            <span class="font-semibold mt-2">Yape</span>
                        </div>
                    </div>
                    <!-- Formulario de tarjeta (solo visual) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium mb-1">Titular</label>
                            <input type="text" name="titular" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Número de tarjeta</label>
                            <input type="text" name="numero_tarjeta" class="w-full border rounded px-3 py-2" placeholder="0000 - 0000 - 0000 - 0000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">CVV</label>
                            <input type="text" name="cvv" class="w-full border rounded px-3 py-2" placeholder="123">
                        </div>
                        <div class="flex gap-2">
                            <div>
                                <label class="block text-sm font-medium mb-1">Mes</label>
                                <input type="text" name="mes" class="w-full border rounded px-3 py-2" placeholder="MM">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Año</label>
                                <input type="text" name="ano" class="w-full border rounded px-3 py-2" placeholder="AAAA">
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('pago.mercadopago') }}" method="POST">
                        @csrf
                        <input type="hidden" name="monto" value="{{ $total + 15 - ($descuento ?? 0) }}">
                        <button type="submit" class="w-full bg-[#00B1EA] hover:bg-[#0097CE] text-white font-bold py-3 rounded-lg text-lg transition mt-4 flex items-center justify-center gap-2">
                            <img src="{{ asset('icons/mercadopago.svg') }}" alt="MercadoPago" class="w-6 h-6"> Pagar con MercadoPago
                        </button>
                    </form>
                </div>
                <div class="flex flex-col md:flex-row gap-4 mt-8">
                    <button type="button" onclick="window.location='{{ route('carrito.index') }}'" class="bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow flex items-center gap-2 w-max">Volver al carrito</button>
                    <button type="submit" form="formPedido" class="w-full bg-[#0A2342] hover:bg-[#EAA451] text-white font-bold py-3 rounded-lg text-lg transition">CONFIRMAR COMPRA</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function actualizarEntrega() {
    document.getElementById('entregaNombre').textContent = document.getElementById('inputNombre').value;
    // Formatear fecha a dd/mm/yyyy
    let fecha = document.getElementById('inputFecha').value;
    if(fecha) {
        let partes = fecha.split('-');
        if(partes.length === 3) {
            document.getElementById('entregaFecha').textContent = partes[2] + '/' + partes[1] + '/' + partes[0];
        } else {
            document.getElementById('entregaFecha').textContent = fecha;
        }
    } else {
        document.getElementById('entregaFecha').textContent = '';
    }
    document.getElementById('entregaDireccion').textContent = document.getElementById('inputDireccion').value;
    document.getElementById('entregaTelefono').textContent = document.getElementById('inputTelefono').value;
}
// Actualizar automáticamente al cargar por si hay valores precargados
window.addEventListener('DOMContentLoaded', actualizarEntrega);
</script>
@endpush 