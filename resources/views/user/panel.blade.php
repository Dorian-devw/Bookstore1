@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Panel de Usuario</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    <!-- Información del usuario -->
    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Bienvenido, {{ $user->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $pedidos->count() }}</div>
                <div class="text-gray-600">Pedidos realizados</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $favoritos->count() }}</div>
                <div class="text-gray-600">Libros favoritos</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $direcciones->count() }}</div>
                <div class="text-gray-600">Direcciones guardadas</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Últimos pedidos -->
        <div class="bg-white rounded shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Últimos pedidos</h2>
                <a href="{{ route('user.pedidos') }}" class="text-blue-600 hover:underline">Ver todos</a>
            </div>
            @if($pedidos->isEmpty())
                <div class="text-gray-500">No tienes pedidos aún.</div>
            @else
                <div class="space-y-3">
                    @foreach($pedidos as $pedido)
                        <div class="border-b pb-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">Pedido #{{ $pedido->id }}</div>
                                    <div class="text-sm text-gray-600">{{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y') : '-' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold">S/ {{ number_format($pedido->total, 2) }}</div>
                                    <div class="text-sm text-gray-600">{{ ucfirst($pedido->estado) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Favoritos -->
        <div class="bg-white rounded shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Libros favoritos</h2>
                <a href="{{ route('user.favoritos') }}" class="text-blue-600 hover:underline">Ver todos</a>
            </div>
            @if($favoritos->isEmpty())
                <div class="text-gray-500">No tienes libros favoritos.</div>
            @else
                <div class="space-y-3">
                    @foreach($favoritos as $favorito)
                        <div class="flex items-center gap-3 border-b pb-2">
                            <img src="{{ $favorito->libro->imagen ? asset($favorito->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $favorito->libro->titulo }}" class="w-12 h-16 object-cover rounded">
                            <div class="flex-1">
                                <div class="font-semibold">{{ $favorito->libro->titulo }}</div>
                                <div class="text-sm text-gray-600">{{ $favorito->libro->autor->nombre ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Historial reciente -->
        <div class="bg-white rounded shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Historial reciente</h2>
                <a href="{{ route('user.historial') }}" class="text-blue-600 hover:underline">Ver todo</a>
            </div>
            @if($historial->isEmpty())
                <div class="text-gray-500">No has visto libros recientemente.</div>
            @else
                <div class="space-y-3">
                    @foreach($historial as $visto)
                        <div class="flex items-center gap-3 border-b pb-2">
                            <img src="{{ $visto->libro->imagen ? asset($visto->libro->imagen) : asset('images/default-book.png') }}" alt="{{ $visto->libro->titulo }}" class="w-12 h-16 object-cover rounded">
                            <div class="flex-1">
                                <div class="font-semibold">{{ $visto->libro->titulo }}</div>
                                <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($visto->visto_en)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Acciones rápidas -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Acciones rápidas</h2>
            <div class="space-y-3">
                <a href="{{ route('user.perfil') }}" class="block p-3 border rounded hover:bg-gray-50">
                    <div class="font-semibold">Editar perfil</div>
                    <div class="text-sm text-gray-600">Actualizar información personal</div>
                </a>
                <a href="{{ route('user.direcciones') }}" class="block p-3 border rounded hover:bg-gray-50">
                    <div class="font-semibold">Gestionar direcciones</div>
                    <div class="text-sm text-gray-600">Agregar o editar direcciones de envío</div>
                </a>
                <a href="{{ route('catalogo') }}" class="block p-3 border rounded hover:bg-gray-50">
                    <div class="font-semibold">Explorar catálogo</div>
                    <div class="text-sm text-gray-600">Ver todos los libros disponibles</div>
                </a>
                <a href="{{ route('carrito.index') }}" class="block p-3 border rounded hover:bg-gray-50">
                    <div class="font-semibold">Ver carrito</div>
                    <div class="text-sm text-gray-600">Revisar productos en el carrito</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 