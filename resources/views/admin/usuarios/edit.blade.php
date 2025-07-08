@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Editar Usuario</h1>
        <a href="{{ route('admin.usuarios.index') }}" class="text-blue-700 hover:underline font-semibold flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la gestión de usuarios
        </a>
    </div>

    <!-- Información del usuario -->
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
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-blue-100 text-blue-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Total Pedidos</div>
            <div class="text-3xl font-bold mt-2">{{ $usuario->pedidos()->count() }}</div>
        </div>
        <div class="bg-green-100 text-green-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Favoritos</div>
            <div class="text-3xl font-bold mt-2">{{ $usuario->favoritos()->count() }}</div>
        </div>
        <div class="bg-purple-100 text-purple-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Direcciones</div>
            <div class="text-3xl font-bold mt-2">{{ $usuario->direcciones()->count() }}</div>
        </div>
        <div class="bg-orange-100 text-orange-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Reseñas</div>
            <div class="text-3xl font-bold mt-2">{{ $usuario->resenas()->count() }}</div>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h3 class="text-lg font-semibold mb-6 text-gray-800">Información del Usuario</h3>
        
        <form method="POST" action="{{ route('admin.usuarios.update', $usuario->id) }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Estado de verificación -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-md font-semibold mb-4 text-gray-800">Estado de la cuenta</h4>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="email_verified" name="email_verified" value="1" 
                               {{ $usuario->email_verified_at ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="email_verified" class="ml-3 text-sm font-medium text-gray-700">
                            Email verificado
                        </label>
                        <span class="ml-2 text-xs text-gray-500">
                            @if($usuario->email_verified_at)
                                Verificado el {{ $usuario->email_verified_at->format('d/m/Y H:i') }}
                            @else
                                Pendiente de verificación
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                               {{ !$usuario->deleted_at ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                            Cuenta activa
                        </label>
                        <span class="ml-2 text-xs text-gray-500">
                            El usuario puede acceder al sistema
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-md font-semibold mb-4 text-gray-800">Información adicional</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="font-medium text-gray-900">Último acceso</div>
                        <div class="text-gray-600">
                            {{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i') : 'Nunca' }}
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="font-medium text-gray-900">Total gastado</div>
                        <div class="text-gray-600">
                            S/ {{ number_format($usuario->pedidos()->sum('total'), 2) }}
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="font-medium text-gray-900">Pedidos completados</div>
                        <div class="text-gray-600">
                            {{ $usuario->pedidos()->where('estado', 'completado')->count() }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
                <div class="flex gap-3">
                    <a href="{{ route('admin.usuarios.pedidos', $usuario->id) }}" 
                       class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>Ver pedidos
                    </a>
                    
                    <button type="button" 
                            class="inline-flex items-center gap-2 bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>Resetear contraseña
                    </button>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.usuarios.index') }}" 
                       class="inline-flex items-center gap-2 bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition font-semibold">
                        Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 