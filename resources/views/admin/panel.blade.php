@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Panel de Administración</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-12 items-start">
        <!-- Gestiones rápidas -->
        <aside class="w-full">
            <div class="bg-white rounded-2xl shadow-lg p-8 sticky top-8">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Gestiones rápidas</h2>
                <div class="space-y-4">
                    <a href="{{ route('admin.libros.index') }}" class="block p-5 rounded-xl border transition-colors bg-blue-50 hover:bg-blue-100 border-blue-200">
                        <div class="font-semibold text-blue-800 text-lg">📚 Gestión de libros</div>
                        <div class="text-sm text-blue-600 mt-1">Agregar, editar y eliminar libros</div>
                    </a>
                    <a href="{{ route('admin.stock.index') }}" class="block p-5 rounded-xl border transition-colors bg-green-50 hover:bg-green-100 border-green-200">
                        <div class="font-semibold text-green-800 text-lg">📦 Control de stock</div>
                        <div class="text-sm text-green-600 mt-1">Gestionar inventario</div>
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" class="block p-5 rounded-xl border transition-colors bg-purple-50 hover:bg-purple-100 border-purple-200">
                        <div class="font-semibold text-purple-800 text-lg">👥 Gestión de usuarios</div>
                        <div class="text-sm text-purple-600 mt-1">Ver usuarios y sus pedidos</div>
                    </a>
                    <a href="{{ route('admin.pedidos.index') }}" class="block p-5 rounded-xl border transition-colors bg-orange-50 hover:bg-orange-100 border-orange-200">
                        <div class="font-semibold text-orange-800 text-lg">📋 Gestión de pedidos</div>
                        <div class="text-sm text-orange-600 mt-1">Ver y gestionar pedidos</div>
                    </a>
                    <a href="{{ route('admin.resenas.index') }}" class="block p-5 rounded-xl border transition-colors bg-yellow-50 hover:bg-yellow-100 border-yellow-200">
                        <div class="font-semibold text-yellow-800 text-lg">⭐ Moderación de reseñas</div>
                        <div class="text-sm text-yellow-600 mt-1">Aprobar o rechazar reseñas</div>
                    </a>
                    <button type="button" onclick="document.getElementById('modal-reportes').classList.remove('hidden')" class="block w-full text-left p-5 rounded-xl border transition-colors bg-gray-50 hover:bg-gray-100 border-gray-200">
                        <div class="font-semibold text-gray-800 text-lg">📊 Reportes</div>
                        <div class="text-sm text-gray-600 mt-1">Generar reportes</div>
                    </button>
                </div>
            </div>
        </aside>
        <!-- Contenido principal -->
        <main class="w-full">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div class="bg-blue-100 text-blue-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Ventas del mes</div>
                    <div class="text-3xl font-bold mt-2">S/ {{ number_format($ventasMes, 2) }}</div>
                </div>
                <div class="bg-green-100 text-green-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Usuarios registrados</div>
                    <div class="text-3xl font-bold mt-2">{{ $usuarios }}</div>
                </div>
                <div class="bg-yellow-100 text-yellow-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Pedidos pendientes</div>
                    <div class="text-3xl font-bold mt-2">{{ $pedidosPendientes }}</div>
                </div>
                <div class="bg-indigo-100 text-indigo-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Pedidos completados</div>
                    <div class="text-3xl font-bold mt-2">{{ $pedidosCompletados }}</div>
                </div>
            </div>
            <!-- Libros más vendidos y alertas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-5">Libros más vendidos</h2>
                    <div class="space-y-3">
                        @foreach($masVendidos as $libro)
                            <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl">
                                <div class="w-12 h-16 bg-gray-200 rounded shadow-sm overflow-hidden flex-shrink-0">
                                    @if($libro->imagen)
                                        <img src="{{ asset('storage/' . $libro->imagen) }}" 
                                             alt="{{ $libro->titulo }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen'">
                                    @else
                                        <img src="https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen" 
                                             alt="{{ $libro->titulo }}" 
                                             class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 text-base truncate">{{ $libro->titulo }}</div>
                                    <div class="text-sm text-gray-600">{{ $libro->autor->nombre ?? 'Autor desconocido' }}</div>
                                </div>
                                <div class="text-blue-700 font-bold text-lg">
                                    {{ $libro->vendidos ?? 0 }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow p-8">
                    <h2 class="text-xl font-semibold mb-5 text-red-700">Alertas de stock bajo</h2>
                    @if($stockBajo->isEmpty())
                        <div class="text-green-600 flex items-center gap-2 text-base">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            No hay libros con stock bajo.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($stockBajo->sortBy(function($libro) { return $libro->stock === 0 ? -1 : $libro->stock; }) as $libro)
                                <div class="flex items-center gap-3 p-3 rounded-xl transition
                                    @if($libro->stock == 0)
                                        hover:bg-red-50
                                    @elseif($libro->stock > 0 && $libro->stock <= 10)
                                        hover:bg-yellow-50
                                    @else
                                        hover:bg-gray-50
                                    @endif
                                ">
                                    <div class="w-12 h-16 bg-gray-200 rounded shadow-sm overflow-hidden flex-shrink-0">
                                        @if($libro->imagen)
                                            <img src="{{ asset('storage/' . $libro->imagen) }}" 
                                                 alt="{{ $libro->titulo }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen'">
                                        @else
                                            <img src="https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen" 
                                                 alt="{{ $libro->titulo }}" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-gray-900 text-base truncate">{{ $libro->titulo }}</div>
                                        <div class="text-sm text-gray-600">{{ $libro->autor->nombre ?? 'Autor desconocido' }}</div>
                                    </div>
                                    <div class="text-red-600 font-bold text-lg">
                                        {{ $libro->stock }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
<!-- Modal de reportes -->
<div id="modal-reportes" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md relative">
        <button onclick="document.getElementById('modal-reportes').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Generar reporte</h2>
        <form method="GET" action="{{ route('admin.reportes.pdf') }}" target="_blank" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de reporte</label>
                <select name="tipo" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="ventas">Ventas</option>
                    <option value="stock">Stock</option>
                    <option value="usuarios">Usuarios</option>
                    <option value="pedidos">Pedidos</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Descargar PDF</button>
        </form>
    </div>
</div>
@endsection 