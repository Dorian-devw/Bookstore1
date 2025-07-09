@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl w-full mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-4xl font-bold">Moderación de Reseñas</h1>
        <a href="{{ route('admin.panel') }}" class="text-blue-700 hover:underline font-semibold">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>Volver al panel
        </a>
    </div>
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-800 border border-green-200 rounded-2xl">{{ session('success') }}</div>
    @endif

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
        <div class="bg-blue-100 text-blue-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Total de reseñas</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\Resena::count() }}</div>
        </div>
        <div class="bg-yellow-100 text-yellow-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Pendientes</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\Resena::where('estado', 'pendiente')->count() }}</div>
        </div>
        <div class="bg-green-100 text-green-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Aprobadas</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\Resena::where('estado', 'aprobado')->count() }}</div>
        </div>
        <div class="bg-red-100 text-red-900 rounded-2xl shadow p-8 flex flex-col items-center">
            <div class="text-base font-semibold">Rechazadas</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\Resena::where('estado', 'rechazado')->count() }}</div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Filtros de búsqueda</h2>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="estado" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Calificación</label>
                <select name="calificacion" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todas las calificaciones</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('calificacion') == $i ? 'selected' : '' }}>{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition">Filtrar</button>
                <a href="{{ route('admin.resenas.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-600 transition">Limpiar</a>
            </div>
        </form>
    </div>

    <!-- Lista de reseñas -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Reseñas para moderar</h2>
        
        @if($resenas->count() > 0)
            <div class="space-y-6">
                @foreach($resenas as $resena)
                    <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-md transition-shadow">
                        <div class="flex flex-col lg:flex-row gap-6">
                            <!-- Información del libro -->
                            <div class="flex-1">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-16 h-20 bg-gray-200 rounded-lg shadow-sm overflow-hidden flex-shrink-0">
                                        @if($resena->libro->imagen)
                                            <img src="{{ asset($resena->libro->imagen) }}" 
                                                 alt="{{ $resena->libro->titulo }}" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='{{ asset('images/default-book.jpg') }}'">
                                        @else
                                            <img src="{{ asset('images/default-book.jpg') }}" 
                                                 alt="{{ $resena->libro->titulo }}" 
                                                 class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $resena->libro->titulo }}</h3>
                                        <p class="text-gray-600 mb-2">{{ $resena->libro->autor->nombre ?? 'Autor desconocido' }}</p>
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span>{{ $resena->created_at->format('d/m/Y H:i') }}</span>
                                            <span>•</span>
                                            <span>ID: {{ $resena->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del usuario -->
                            <div class="lg:w-48">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="font-semibold text-gray-900 mb-1">{{ $resena->user->name ?? 'Usuario' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $resena->user->email ?? 'Sin email' }}</p>
                                </div>
                            </div>

                            <!-- Calificación -->
                            <div class="lg:w-32">
                                <div class="text-center">
                                    <div class="flex justify-center gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $resena->calificacion ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
                                        @endfor
                                    </div>
                                    <span class="text-lg font-bold text-gray-900">{{ $resena->calificacion }}/5</span>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="lg:w-32">
                                <div class="text-center">
                                    @if($resena->estado === 'aprobado')
                                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-800 font-semibold text-sm">Aprobada</span>
                                    @elseif($resena->estado === 'rechazado')
                                        <span class="px-4 py-2 rounded-full bg-red-100 text-red-800 font-semibold text-sm">Rechazada</span>
                                    @else
                                        <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-sm">Pendiente</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="lg:w-48">
                                <div class="flex flex-col gap-2">
                                    @if($resena->estado !== 'aprobado')
                                        <form action="{{ route('admin.resenas.moderar', $resena->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="estado" value="aprobado">
                                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-green-700 transition text-sm" onclick="return confirm('¿Aprobar esta reseña?')">
                                                ✅ Aprobar
                                            </button>
                                        </form>
                                    @endif
                                    @if($resena->estado !== 'rechazado')
                                        <form action="{{ route('admin.resenas.moderar', $resena->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="estado" value="rechazado">
                                            <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-700 transition text-sm" onclick="return confirm('¿Rechazar esta reseña?')">
                                                ❌ Rechazar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Comentario expandido -->
                        @if($resena->comentario)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-semibold text-gray-900 mb-3">Comentario:</h4>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $resena->comentario }}</p>
                                </div>
                            </div>
                        @else
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="text-gray-400 italic text-center">Sin comentario</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $resenas->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay reseñas para moderar</h3>
                <p class="text-gray-600">No se encontraron reseñas con los filtros aplicados.</p>
            </div>
        @endif
    </div>
</div>
@endsection 