@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl w-full mx-auto px-8"> {{-- Aumentado a 7xl --}}
        <div class="w-full flex flex-col md:flex-row gap-8"> {{-- w-full añadido --}}
            <!-- Imagen del libro -->
            <div class="flex-[0_0_260px] flex justify-center mb-6 md:mb-0">
                <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png') }}" alt="{{ $libro->titulo }}" class="w-60 h-80 object-cover rounded shadow">
            </div>
            <!-- Info principal y tabs -->
            <div class="flex-1 min-w-0 flex flex-col gap-2">
                <h1 class="text-3xl font-bold mb-1">{{ $libro->titulo }}</h1>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-yellow-500 text-xl font-bold">{{ number_format($libro->valoracion, 1) }}</span>
                    <span class="text-yellow-400">★</span>
                    <span class="text-gray-500 text-sm">{{ $libro->resenasAprobadas()->count() }} Reseñas</span>
                </div>
                <div class="flex flex-wrap gap-4 text-sm mb-2">
                    <div><span class="font-semibold">Autor:</span> {{ $libro->autor->nombre ?? '-' }}</div>
                    <div><span class="font-semibold">Editorial:</span> {{ $libro->editorial ?? 'Planeta' }}</div>
                    <div><span class="font-semibold">Año:</span> {{ $libro->publicado_en ?? '-' }}</div>
                </div>
                <div class="flex gap-2 mb-2">
                    <span class="flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                        <img src="{{ asset('icons/rayo.svg') }}" alt="Rápido" class="w-4 h-4"> ENTREGA RÁPIDA
                    </span>
                    <span class="flex items-center gap-1 px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">
                        <img src="{{ asset('icons/escudo.svg') }}" alt="Seguro" class="w-4 h-4"> Seguro
                    </span>
                </div>
                <p class="text-gray-700 mb-4">{{ $libro->descripcion }}</p>
                <div class="text-3xl font-bold text-blue-700 mb-2">s/{{ number_format($libro->precio, 2) }}</div>
                
                <!-- Alertas de stock -->
                @if(isset($stockDisponible) && $stockDisponible < $libro->stock)
                    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-yellow-800 font-medium">¡Atención!</span>
                        </div>
                        <p class="text-yellow-700 text-sm mt-1">
                            Solo hay <strong>{{ $stockDisponible }}</strong> unidades disponibles de {{ $libro->stock }} en total.
                            @if($stockReservado > 0)
                                <strong>{{ $stockReservado }} unidades</strong> están siendo compradas por otros clientes en este momento.
                            @endif
                        </p>
                    </div>
                @endif
                
                @if(isset($stockDisponible) && $stockDisponible <= 3 && $stockDisponible > 0)
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-red-800 font-medium">¡Últimas unidades!</span>
                        </div>
                        <p class="text-red-700 text-sm mt-1">
                            Solo quedan <strong>{{ $stockDisponible }} unidades</strong> disponibles. ¡Apúrate antes de que se agoten!
                        </p>
                    </div>
                @endif
                
                @if(isset($stockDisponible) && $stockDisponible == 0)
                    <div class="mb-4 p-3 bg-gray-100 border border-gray-300 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 002 0V5zm-1 8a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700 font-medium">Este libro está <strong>agotado</strong> actualmente.</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">Lo sentimos. Vuelve al catálogo, para que puedas comprar otro libro.</p>
                    </div>
                @endif
                
                @if(isset($stockDisponible) && $stockDisponible == 0)
                    <div class="flex items-center gap-2 mb-2">
                        <button class="ml-4 bg-gray-300 text-gray-500 font-semibold px-6 py-2 rounded shadow cursor-not-allowed" disabled>Agotado</button>
                    </div>
                @else
                    <div class="flex items-center gap-2 mb-2">
                        <form action="{{ route('carrito.agregar') }}" method="POST" class="flex items-center gap-2" onsubmit="setTimeout(function(){ window.location.href='{{ route('carrito.index') }}'; }, 100);">
                            @csrf
                            <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-2 py-1 border rounded">-</button>
                            <input type="number" name="cantidad" value="1" min="1" max="{{ $stockDisponible ?? $libro->stock }}" class="w-14 border rounded text-center">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-2 py-1 border rounded">+</button>
                            <span class="ml-2 text-sm text-gray-500">
                                Ejemplares disponibles: <strong>{{ $stockDisponible ?? $libro->stock }}</strong>
                                @if(isset($stockReservado) && $stockReservado > 0)
                                    <span class="text-yellow-600">({{ $stockReservado }} reservados)</span>
                                @endif
                            </span>
                            <button type="submit" class="ml-4 bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow transition">Añadir al carrito</button>
                        </form>
                    </div>
                @endif

                <!-- Tabs alineados horizontalmente con el cuadro de resumen -->
                <div class="w-full flex flex-row gap-8 mt-8"> {{-- w-full añadido --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex border-b mb-4">
                            <button id="tabBtnDetalles" class="px-6 py-2 font-semibold border-b-2 focus:outline-none tab-active" style="border-color: #EAA451; color: #EAA451;" onclick="mostrarTab('detalles')">Detalles del libro</button>
                            <button id="tabBtnResenas" class="px-6 py-2 font-semibold text-gray-400 hover:text-[#EAA451]" style="border-bottom: 2px solid transparent;" onclick="mostrarTab('resenas')">Reseñas</button>
                        </div>
                        <div id="tab-detalles" class="block">
                            <table class="w-full bg-white rounded shadow mb-6">
                                <tbody>
                                    <tr><td class="font-semibold py-2 px-4">Fecha de publicación</td><td class="py-2 px-4">{{ $libro->publicado_en ?? '-' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Tamaño</td><td class="py-2 px-4">{{ $libro->tamano ?? '220 mm x 140 mm' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">ISBN</td><td class="py-2 px-4">{{ $libro->isbn ?? '2563541274588569' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Nro. de páginas</td><td class="py-2 px-4">{{ $libro->paginas ?? '160' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Precio</td><td class="py-2 px-4">s/ {{ number_format($libro->precio, 2) }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Cantidad disponible</td><td class="py-2 px-4">{{ $libro->stock }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Editorial</td><td class="py-2 px-4">{{ $libro->editorial ?? 'Planeta    ' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Categoría</td><td class="py-2 px-4"><span class="px-2 py-1 bg-[#EAA451] text-white rounded">{{ $libro->categoria->nombre ?? '-' }}</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="tab-resenas" class="hidden">
                            @include('resenas.index', ['libro' => $libro])
                        </div>
                    </div>
                    <!-- Resumen y comentarios -->
                    <div class="flex-[0_0_260px] flex flex-col gap-6">
                        <div class="bg-white rounded shadow p-4 flex flex-col gap-2">
                            <div class="font-semibold mb-2">{{ $libro->titulo }}</div>
                            @if(Auth::check())
                                <button type="button" onclick="agregarAFavoritos({{ $libro->id }}, this)" class="w-full flex items-center justify-center gap-2 bg-[#EAA451] hover:bg-orange-500 text-white font-semibold py-2 rounded shadow transition">
                                    <img src="{{ asset('icons/favorito.svg') }}" alt="Favorito" class="w-5 h-5">
                                    Añadir a favoritos
                                </button>
                            @else
                                <a href="{{ route('carrito.advertencia_login') }}" class="w-full flex items-center justify-center gap-2 bg-[#EAA451] hover:bg-orange-500 text-white font-semibold py-2 rounded shadow transition">
                                    <img src="{{ asset('icons/favorito.svg') }}" alt="Favorito" class="w-5 h-5">
                                    Añadir a favoritos
                                </a>
                            @endif
                        </div>
                        <div class="bg-white rounded shadow p-4">
                            <div class="font-semibold mb-2">Comentarios</div>
                            @if($libro->resenasAprobadas()->count() > 0)
                                @php $resena = $libro->resenasAprobadas()->latest()->first(); @endphp
                                <div class="flex items-center gap-2 mb-1">
                            
                                    <span class="font-semibold text-sm">{{ $resena->user->name ?? 'Usuario' }}</span>
                                    <span class="text-yellow-400 text-xs">{{ $resena->calificacion }} ★</span>
                                </div>
                                <div class="text-gray-700 text-sm mb-1">{{ $resena->comentario }}</div>
                            @else
                                <div class="text-gray-500 text-sm">Aún no hay comentarios.</div>
                            @endif
                            <div class="mt-2 text-xs text-gray-500">
                                Disponibles actualmente: <strong>{{ $stockDisponible ?? $libro->stock }}</strong>
                                @if(isset($stockReservado) && $stockReservado > 0)
                                    <br><span class="text-yellow-600">({{ $stockReservado }} reservados)</span>
                                @endif
                                <br>Veces vendidos: {{ $libro->veces_vendido ?? '-' }}<br>
                                Tasa de respuesta: 100%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Libros Recomendados -->
        @if(isset($recomendados) && $recomendados->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-left text-[#0A2342] mb-8">Libros relacionados</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8 justify-center">
                    @foreach($recomendados as $libro)
                        <div class="flex flex-col items-center relative group">
                            <a href="{{ route('libro.detalle', $libro->id) }}" class="block w-full relative">
                                <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png') }}"
                                    alt="{{ $libro->titulo }}"
                                    class="w-40 h-56 object-cover rounded shadow mb-3">
                                <button onclick="toggleFavorito({{ $libro->id }}, this)" class="absolute top-2 right-2 w-7 h-7 opacity-80 group-hover:scale-110 transition-transform z-10">
                                    <img src="{{ asset('icons/favorito.svg') }}" alt="Favorito" class="w-full h-full {{ Auth::check() && Auth::user()->favoritos()->where('libro_id', $libro->id)->exists() ? 'filter brightness-0 invert' : '' }}">
                                </button>
                            </a>
                            <a href="{{ route('libro.detalle', $libro->id) }}" class="font-bold text-sm text-[#0A2342] uppercase text-center truncate w-full hover:underline" title="{{ $libro->titulo }}">
                                {{ Str::limit(mb_strtoupper($libro->titulo), 22) }}
                            </a>
                            <div class="text-gray-600 text-sm text-center mt-1">s/{{ number_format($libro->precio, 2) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function mostrarTab(tab) {
    document.getElementById('tab-detalles').classList.toggle('hidden', tab !== 'detalles');
    document.getElementById('tab-resenas').classList.toggle('hidden', tab !== 'resenas');
    const btnDetalles = document.getElementById('tabBtnDetalles');
    const btnResenas = document.getElementById('tabBtnResenas');
    if(tab === 'detalles') {
        btnDetalles.style.borderColor = '#EAA451';
        btnDetalles.style.color = '#EAA451';
        btnResenas.style.borderColor = 'transparent';
        btnResenas.style.color = '#A0AEC0';
    } else {
        btnDetalles.style.borderColor = 'transparent';
        btnDetalles.style.color = '#A0AEC0';
        btnResenas.style.borderColor = '#EAA451';
        btnResenas.style.color = '#EAA451';
    }
}
mostrarTab('detalles');

function toggleFavorito(libroId, button) {
    event.preventDefault();
    event.stopPropagation();
    
    if (!{{ Auth::check() ? 'true' : 'false' }}) {
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const img = button.querySelector('img');
    const isFavorito = img.classList.contains('filter');
    
    // Crear FormData
    const formData = new FormData();
    formData.append('libro_id', libroId);
    formData.append('action', isFavorito ? 'remove' : 'add');
    formData.append('_token', '{{ csrf_token() }}');
    
    // Enviar petición AJAX
    fetch('{{ route("user.favoritos.toggle") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cambiar visual del botón
            if (isFavorito) {
                img.classList.remove('filter', 'brightness-0', 'invert');
            } else {
                img.classList.add('filter', 'brightness-0', 'invert');
            }
            
            // Mostrar notificación
            mostrarNotificacion(data.message, 'success');
        } else {
            mostrarNotificacion(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('Error al procesar la solicitud', 'error');
    });
}

function mostrarNotificacion(mensaje, tipo) {
    // Crear elemento de notificación
    const notificacion = document.createElement('div');
    notificacion.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        tipo === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notificacion.textContent = mensaje;
    
    // Agregar al DOM
    document.body.appendChild(notificacion);
    
    // Animar entrada
    setTimeout(() => {
        notificacion.classList.remove('translate-x-full');
    }, 100);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notificacion.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notificacion);
        }, 300);
    }, 3000);
}

function agregarAFavoritos(libroId, button) {
    const formData = new FormData();
    formData.append('libro_id', libroId);
    formData.append('_token', '{{ csrf_token() }}');
    fetch('{{ route('user.favoritos.store') }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Añadido a favoritos');
            button.classList.add('bg-red-50');
        } else {
            showNotification(data.message || 'Error al añadir a favoritos', 'error');
        }
    })
    .catch(() => {
        showNotification('Error al procesar la solicitud', 'error');
    });
}
</script>
@endsection
