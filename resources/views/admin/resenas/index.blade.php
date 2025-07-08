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
        <div class="mb-4 p-3 bg-green-50 text-green-800 border border-green-200 rounded-xl">{{ session('success') }}</div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-2xl shadow-lg">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Libro</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Calificación</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Comentario</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($resenas as $resena)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold">{{ $resena->libro->titulo ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $resena->user->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $resena->calificacion }} ⭐</td>
                        <td class="px-6 py-4 max-w-xs truncate">{{ $resena->comentario }}</td>
                        <td class="px-6 py-4">
                            @if($resena->estado === 'aprobado')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs">Aprobada</span>
                            @elseif($resena->estado === 'rechazado')
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-xs">Rechazada</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold text-xs">Pendiente</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.resenas.moderar', $resena->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="estado" value="aprobado">
                                <button type="submit" class="px-3 py-1.5 bg-green-50 text-green-800 border border-green-200 rounded-lg font-semibold text-xs hover:bg-green-100 transition">Aprobar</button>
                            </form>
                            <form action="{{ route('admin.resenas.moderar', $resena->id) }}" method="POST" class="inline ml-1">
                                @csrf
                                <input type="hidden" name="estado" value="rechazado">
                                <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-800 border border-red-200 rounded-lg font-semibold text-xs hover:bg-red-100 transition">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-500">No hay reseñas para moderar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $resenas->links() }}
        </div>
    </div>
</div>
@endsection 