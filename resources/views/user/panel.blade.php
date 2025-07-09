@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Panel de Usuario</h1>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-2xl">{{ session('success') }}</div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-12 items-start">
        <!-- Gestiones rápidas -->
        <aside class="w-full">
            <div class="bg-white rounded-2xl shadow-lg p-8 sticky top-8">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Acciones rápidas</h2>
                <div class="space-y-4">
                    <a href="{{ route('user.perfil') }}" class="block p-5 rounded-xl border transition-colors bg-blue-50 hover:bg-blue-100 border-blue-200">
                        <div class="font-semibold text-blue-800 text-lg">👤 Mi Perfil</div>
                        <div class="text-sm text-blue-600 mt-1">Actualizar información personal</div>
                    </a>
                    <a href="{{ route('user.direcciones') }}" class="block p-5 rounded-xl border transition-colors bg-green-50 hover:bg-green-100 border-green-200">
                        <div class="font-semibold text-green-800 text-lg">📍 Mis Direcciones</div>
                        <div class="text-sm text-green-600 mt-1">Gestionar direcciones de envío</div>
                    </a>
                    <a href="{{ route('user.pedidos') }}" class="block p-5 rounded-xl border transition-colors bg-purple-50 hover:bg-purple-100 border-purple-200">
                        <div class="font-semibold text-purple-800 text-lg">📋 Mis Pedidos</div>
                        <div class="text-sm text-purple-600 mt-1">Ver historial de compras</div>
                    </a>
                    <a href="{{ route('user.favoritos') }}" class="block p-5 rounded-xl border transition-colors bg-orange-50 hover:bg-orange-100 border-orange-200">
                        <div class="font-semibold text-orange-800 text-lg">❤️ Mis Favoritos</div>
                        <div class="text-sm text-orange-600 mt-1">Libros guardados</div>
                    </a>
                    <a href="{{ route('catalogo') }}" class="block p-5 rounded-xl border transition-colors bg-yellow-50 hover:bg-yellow-100 border-yellow-200">
                        <div class="font-semibold text-yellow-800 text-lg">📚 Explorar Catálogo</div>
                        <div class="text-sm text-yellow-600 mt-1">Ver todos los libros</div>
                    </a>
                    <a href="{{ route('carrito.index') }}" class="block p-5 rounded-xl border transition-colors bg-indigo-50 hover:bg-indigo-100 border-indigo-200">
                        <div class="font-semibold text-indigo-800 text-lg">🛒 Mi Carrito</div>
                        <div class="text-sm text-indigo-600 mt-1">Revisar productos</div>
                    </a>
                </div>
            </div>
        </aside>
        
        <!-- Contenido principal -->
        <main class="w-full">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="bg-blue-100 text-blue-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Pedidos realizados</div>
                    <div class="text-3xl font-bold mt-2">{{ $pedidos->count() }}</div>
                </div>
                <div class="bg-green-100 text-green-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Libros favoritos</div>
                    <div class="text-3xl font-bold mt-2">{{ $favoritos->count() }}</div>
                </div>
                <div class="bg-purple-100 text-purple-900 rounded-2xl shadow p-8 flex flex-col items-center">
                    <div class="text-base font-semibold">Direcciones guardadas</div>
                    <div class="text-3xl font-bold mt-2">{{ $direcciones->count() }}</div>
                </div>
            </div>
            
            <!-- Últimos pedidos y favoritos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-white rounded-2xl shadow p-8">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold">Últimos pedidos</h2>
                        <a href="{{ route('user.pedidos') }}" class="text-blue-600 hover:underline text-sm">Ver todos</a>
                    </div>
                    @if($pedidos->isEmpty())
                        <div class="text-gray-500 text-center py-8">No tienes pedidos aún.</div>
                    @else
                        <div class="space-y-3">
                            @foreach($pedidos as $pedido)
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-xl">
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-900">Pedido #{{ $pedido->id }}</div>
                                        <div class="text-sm text-gray-600">{{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') : '-' }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-900">S/ {{ number_format($pedido->total, 2) }}</div>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($pedido->estado == 'completado') bg-green-100 text-green-800
                                            @elseif($pedido->estado == 'enviado') bg-blue-100 text-blue-800
                                            @elseif($pedido->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="bg-white rounded-2xl shadow p-8">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold">Libros favoritos</h2>
                        <a href="{{ route('user.favoritos') }}" class="text-blue-600 hover:underline text-sm">Ver todos</a>
                    </div>
                    @if($favoritos->isEmpty())
                        <div class="text-gray-500 text-center py-8">No tienes libros favoritos.</div>
                    @else
                        <div class="space-y-3">
                            @foreach($favoritos as $favorito)
                                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl">
                                    <div class="w-12 h-16 bg-gray-200 rounded shadow-sm overflow-hidden flex-shrink-0">
                                        @if($favorito->libro->imagen)
                                            <img src="{{ asset($favorito->libro->imagen) }}" 
                                                 alt="{{ $favorito->libro->titulo }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen'">
                                        @else
                                            <img src="https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen" 
                                                 alt="{{ $favorito->libro->titulo }}" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-gray-900 text-base truncate">{{ $favorito->libro->titulo }}</div>
                                        <div class="text-sm text-gray-600">{{ $favorito->libro->autor->nombre ?? 'Autor desconocido' }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Historial reciente -->
            <div class="mt-10">
                <div class="bg-white rounded-2xl shadow p-8">
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-xl font-semibold">Historial reciente</h2>
                        <a href="{{ route('user.historial') }}" class="text-blue-600 hover:underline text-sm">Ver todo</a>
                    </div>
                    @if($historial->isEmpty())
                        <div class="text-gray-500 text-center py-8">No has visto libros recientemente.</div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($historial as $visto)
                                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl">
                                    <div class="w-12 h-16 bg-gray-200 rounded shadow-sm overflow-hidden flex-shrink-0">
                                        @if($visto->libro->imagen)
                                            <img src="{{ asset($visto->libro->imagen) }}" 
                                                 alt="{{ $visto->libro->titulo }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen'">
                                        @else
                                            <img src="https://placehold.co/200x300/cccccc/666666?text=Sin+Imagen" 
                                                 alt="{{ $visto->libro->titulo }}" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-gray-900 text-base truncate">{{ $visto->libro->titulo }}</div>
                                        <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($visto->visto_en)->format('d/m/Y') }}</div>
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
@endsection 