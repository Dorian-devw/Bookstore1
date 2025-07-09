@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Gestión de Usuarios</h1>
        <a href="{{ route('admin.panel') }}" class="text-blue-700 hover:underline font-semibold flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>Volver al panel
        </a>
    </div>
    
    <!-- Estadísticas rápidas -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-blue-100 text-blue-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Total Usuarios</div>
            <div class="text-3xl font-bold mt-2">{{ $usuarios->total() }}</div>
        </div>
        <div class="bg-green-100 text-green-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Usuarios Activos</div>
            <div class="text-3xl font-bold mt-2">{{ $usuarios->where('email_verified_at', '!=', null)->count() }}</div>
        </div>
        <div class="bg-purple-100 text-purple-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Con Pedidos</div>
            <div class="text-3xl font-bold mt-2">{{ $usuarios->filter(function($user) { return $user->pedidos()->count() > 0; })->count() }}</div>
        </div>
        <div class="bg-orange-100 text-orange-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Nuevos Hoy</div>
            <div class="text-3xl font-bold mt-2">{{ $usuarios->filter(function($user) { return $user->created_at->isToday(); })->count() }}</div>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="mb-6 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Filtros y Búsqueda</h3>
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar usuario</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" 
                       placeholder="Nombre, correo electrónico..." 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-50 text-blue-800 border border-blue-200 px-6 py-2 rounded-lg hover:bg-blue-100 transition font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>Buscar
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="bg-gray-50 text-gray-800 border border-gray-200 px-6 py-2 rounded-lg hover:bg-gray-100 transition font-semibold">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Información de resultados -->
    <div class="mb-4 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Mostrando {{ $usuarios->firstItem() ?? 0 }} - {{ $usuarios->lastItem() ?? 0 }} de {{ $usuarios->total() }} usuarios
        </div>
        
    </div>

    <!-- Tabla de usuarios -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl shadow-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Información</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actividad</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($usuarios as $usuario)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $usuario->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $usuario->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Registrado: {{ $usuario->created_at->format('d/m/Y') }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $usuario->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        {{ $usuario->pedidos()->count() }} pedidos
                                    </span>
                                </div>
                                @if($usuario->pedidos()->count() > 0)
                                    <div class="text-xs text-gray-500">
                                        Último: {{ $usuario->pedidos()->latest()->first()->created_at->format('d/m/Y') }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.usuarios.pedidos', $usuario->id) }}" 
                                   class="inline-flex items-center gap-2 bg-blue-50 text-blue-800 border border-blue-200 px-3 py-1.5 rounded-lg shadow hover:bg-blue-100 transition font-semibold text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>Ver pedidos
                                </a>
                                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" 
                                   class="inline-flex items-center gap-2 bg-gray-50 text-gray-800 border border-gray-200 px-3 py-1.5 rounded-lg shadow hover:bg-gray-100 transition font-semibold text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>Editar
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="mt-6">
        {{ $usuarios->withQueryString()->links('pagination::simple-tailwind') }}
    </div>
</div>
@endsection 