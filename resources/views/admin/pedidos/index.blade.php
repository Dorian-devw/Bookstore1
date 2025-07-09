@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Gestión de Pedidos</h1>
        <a href="{{ route('admin.panel') }}" class="text-blue-700 hover:underline font-semibold">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>Volver al panel
        </a>
    </div>
    
    
    <!-- Explicación de estados - Más amplia -->
    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Estados de Pedido</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="flex items-center gap-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                    </svg>Pendiente
                </span>
                <span class="text-sm text-gray-700">Pedido realizado, esperando pago o procesamiento</span>
            </div>
            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                    </svg>Enviado
                </span>
                <span class="text-sm text-gray-700">Pedido despachado, en camino al cliente</span>
            </div>
            <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>Completado
                </span>
                <span class="text-sm text-gray-700">Pedido entregado y pagado exitosamente</span>
            </div>
            <div class="flex items-center gap-3 p-3 bg-red-50 rounded-lg border border-red-200">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>Cancelado
                </span>
                <span class="text-sm text-gray-700">Pedido anulado por el usuario o la tienda</span>
            </div>
        </div>
    </div>

    <!-- Filtros avanzados -->
    <div class="mb-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Filtros Avanzados</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Búsqueda por usuario -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar usuario</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" 
                       placeholder="Nombre o correo..." 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Estado del pedido -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado del pedido</label>
                <select name="estado" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" @if(request('estado')=='pendiente') selected @endif>Pendiente</option>
                    <option value="enviado" @if(request('estado')=='enviado') selected @endif>Enviado</option>
                    <option value="completado" @if(request('estado')=='completado') selected @endif>Completado</option>
                    <option value="cancelado" @if(request('estado')=='cancelado') selected @endif>Cancelado</option>
                </select>
            </div>
            
            <!-- Método de pago -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Método de pago</label>
                <select name="metodo_pago" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos los métodos</option>
                    <option value="tarjeta" @if(request('metodo_pago')=='tarjeta') selected @endif>Tarjeta</option>
                    <option value="yape" @if(request('metodo_pago')=='yape') selected @endif>Yape</option>
                    <option value="transferencia" @if(request('metodo_pago')=='transferencia') selected @endif>Transferencia</option>
                </select>
            </div>
            
            <!-- Rango de fechas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Fecha hasta -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Monto mínimo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monto mínimo (S/)</label>
                <input type="number" name="monto_min" value="{{ request('monto_min') }}" 
                       placeholder="0.00" step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Monto máximo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monto máximo (S/)</label>
                <input type="number" name="monto_max" value="{{ request('monto_max') }}" 
                       placeholder="9999.99" step="0.01" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            
            <!-- Botones de acción -->
            <div class="flex gap-2 items-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>Filtrar
                </button>
                <a href="{{ route('admin.pedidos.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition font-semibold">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Mostrando {{ $pedidos->firstItem() ?? 0 }} - {{ $pedidos->lastItem() ?? 0 }} de {{ $pedidos->total() }} pedidos
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl shadow-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Código</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Usuario</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Método</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pedidos as $pedido)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-semibold text-gray-800">#{{ $pedido->id }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $pedido->user->name ?? '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $pedido->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-3 font-bold text-blue-700">S/ {{ number_format($pedido->total, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($pedido->metodo_pago) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($pedido->estado == 'completado')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>Completado
                                </span>
                            @elseif($pedido->estado == 'enviado')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                                    </svg>Enviado
                                </span>
                            @elseif($pedido->estado == 'pendiente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                    </svg>Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 font-semibold">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>Cancelado
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}" 
                               class="inline-flex items-center gap-2 bg-indigo-600 text-white px-3 py-1.5 rounded-lg shadow hover:bg-indigo-700 transition font-semibold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>Ver detalle
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $pedidos->withQueryString()->links() }}
    </div>
</div>
@endsection 