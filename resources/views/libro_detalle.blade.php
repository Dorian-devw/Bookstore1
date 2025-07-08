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
                    <div><span class="font-semibold">Editorial:</span> {{ $libro->editorial ?? '-' }}</div>
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
                <div class="flex items-center gap-2 mb-2">
                    <form action="{{ route('carrito.agregar') }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-2 py-1 border rounded">-</button>
                        <input type="number" name="cantidad" value="1" min="1" max="{{ $libro->stock }}" class="w-14 border rounded text-center">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-2 py-1 border rounded">+</button>
                        <span class="ml-2 text-sm text-gray-500">Ejemplares disponible: {{ $libro->stock }}</span>
                        <button type="submit" class="ml-4 bg-[#EAA451] hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded shadow transition">Añadir al carrito</button>
                    </form>
                </div>

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
                                    <tr><td class="font-semibold py-2 px-4">Tamaño</td><td class="py-2 px-4">{{ $libro->tamano ?? '-' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">ISBN</td><td class="py-2 px-4">{{ $libro->isbn ?? '-' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Nro. de páginas</td><td class="py-2 px-4">{{ $libro->paginas ?? '-' }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Precio</td><td class="py-2 px-4">s/ {{ number_format($libro->precio, 2) }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Cantidad disponible</td><td class="py-2 px-4">{{ $libro->stock }}</td></tr>
                                    <tr><td class="font-semibold py-2 px-4">Editorial</td><td class="py-2 px-4">{{ $libro->editorial ?? '-' }}</td></tr>
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
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-blue-700 font-bold">s/{{ number_format($libro->precio, 2) }}</span>
                            </div>
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="w-full bg-[#EAA451] hover:bg-orange-500 text-white font-semibold py-2 rounded shadow transition">Añadir al carrito</button>
                            </form>
                        </div>
                        <div class="bg-white rounded shadow p-4">
                            <div class="font-semibold mb-2">Comentarios</div>
                            @if($libro->resenasAprobadas()->count() > 0)
                                @php $resena = $libro->resenasAprobadas()->latest()->first(); @endphp
                                <div class="flex items-center gap-2 mb-1">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-8 h-8 rounded-full" alt="">
                                    <span class="font-semibold text-sm">{{ $resena->user->name ?? 'Usuario' }}</span>
                                    <span class="text-yellow-400 text-xs">{{ $resena->calificacion }} ★</span>
                                </div>
                                <div class="text-gray-700 text-sm mb-1">{{ $resena->comentario }}</div>
                            @else
                                <div class="text-gray-500 text-sm">Aún no hay comentarios.</div>
                            @endif
                            <div class="mt-2 text-xs text-gray-500">
                                Disponibles actualmente: {{ $libro->stock }}<br>
                                Veces vendidos: {{ $libro->veces_vendido ?? '-' }}<br>
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
                        <div class="flex flex-col items-center">
                            <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png') }}"
                                alt="{{ $libro->titulo }}"
                                class="w-40 h-56 object-cover rounded shadow mb-3">
                            <div class="font-bold text-sm text-[#0A2342] uppercase text-center truncate w-full" title="{{ $libro->titulo }}">
                                {{ Str::limit(mb_strtoupper($libro->titulo), 22) }}
                            </div>
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
</script>
@endsection
