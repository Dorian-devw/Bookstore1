@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Pedidos del Usuario</h1>
        <a href="{{ route('admin.usuarios.index') }}" class="text-blue-700 hover:underline font-semibold flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la gestión de usuarios
        </a>
    </div>

    <!-- Tarjeta de información del usuario -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-10">
        <div class="flex items-center gap-6">
            <div class="flex-shrink-0">
                <div class="h-16 w-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $usuario->name }}</h2>
                <div class="flex items-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                        {{ $usuario->email }}
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Registrado: {{ $usuario->created_at->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center gap-2">
                        @if($usuario->email_verified_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 font-semibold text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>Verificado
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                </svg>Pendiente
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas de pedidos -->
    <div class="mb-10 mt-2 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-blue-100 text-blue-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Total Pedidos</div>
            <div class="text-3xl font-bold mt-2">{{ $pedidos->total() }}</div>
        </div>
        <div class="bg-green-100 text-green-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Completados</div>
            <div class="text-3xl font-bold mt-2">{{ $pedidos->where('estado', 'completado')->count() }}</div>
        </div>
        <div class="bg-yellow-100 text-yellow-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Pendientes</div>
            <div class="text-3xl font-bold mt-2">{{ $pedidos->where('estado', 'pendiente')->count() }}</div>
        </div>
        <div class="bg-purple-100 text-purple-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Total Gastado</div>
            <div class="text-3xl font-bold mt-2">S/ {{ number_format($pedidos->sum('total'), 2) }}</div>
        </div>
    </div>

    <!-- Información de resultados -->
    <div class="mb-4 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Mostrando {{ $pedidos->firstItem() ?? 0 }} - {{ $pedidos->lastItem() ?? 0 }} de {{ $pedidos->total() }} pedidos
        </div>
    </div>

    <!-- Tabla de pedidos -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl shadow-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Método</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pedidos as $pedido)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">#{{ $pedido->id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') : '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('H:i') : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-blue-700">S/ {{ number_format($pedido->total, 2) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($pedido->metodo_pago) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($pedido->estado == 'completado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>Completado
                                </span>
                            @elseif($pedido->estado == 'enviado')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                                    </svg>Enviado
                                </span>
                            @elseif($pedido->estado == 'pendiente')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                    </svg>Pendiente
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>Cancelado
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}" 
                               class="inline-flex items-center gap-2 bg-indigo-600 text-white px-3 py-1.5 rounded-lg shadow hover:bg-indigo-700 transition font-semibold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>Ver detalle
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay pedidos</h3>
                                <p class="text-gray-500">Este usuario aún no ha realizado ningún pedido.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="mt-6">
        {{ $pedidos->withQueryString()->links('pagination::simple-tailwind') }}
    </div>
</div>
@endsection 