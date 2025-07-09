<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/x-icon" href="{{ asset('bookstore.ico') }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-[#FCFCF6] border-b border-gray-200 py-2">
                <div class="max-w-7xl mx-auto flex items-center justify-between px-4">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2">
                        <img src="{{ asset('bookstore.png') }}" alt="The Flying Bookstore" class="h-12">
                        <span class="font-bold text-xl text-[#0A2342]">The Flying <span class="font-normal">bookstore</span></span>
                    </a>

                    @if(!auth()->check() || (auth()->user() && !auth()->user()->is_admin))
                        
                        <!-- Buscador en vivo -->
                        <div class="relative mx-8 max-w-xl flex-1">
                            <a href="{{ route('catalogo') }}"
                            class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center group"
                            title="Ver catálogo completo"
                            style="background: white; z-index: 9999;">
                                <img src="{{ asset('icons/catalogo.svg') }}" alt="Catálogo" class="w-6 h-6 opacity-80 group-hover:opacity-100 transition">
                            </a>
                            <input id="buscador-libros" type="text" name="q" placeholder="Buscar libro o autor..." autocomplete="off" class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#EAA451]">
                            <div id="resultados-busqueda" class="absolute left-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden"></div>
                        </div>
                    @endif

                    <!-- Botones de sesión solo para usuarios normales -->
                    @if(!auth()->check())
                        <div class="flex gap-2">
                            <a href="{{ route('login') }}" class="px-5 py-2 rounded-lg bg-white border border-[#0A2342] text-[#0A2342] font-semibold hover:bg-gray-100 transition">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-lg bg-[#0A2342] text-white font-semibold hover:bg-[#16335B] transition">Registrarse</a>
                        </div>
                    @elseif(auth()->user() && !auth()->user()->is_admin)
                        <div class="flex gap-2 items-center">
                            <a href="{{ route('carrito.index') }}" class="text-[#0A2342] hover:text-[#16335B]">
                                <img src="{{ asset('icons/carrito.svg') }}" alt="Carrito" class="w-7 h-7">
                            </a>
                            <!-- Menú desplegable del usuario -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 ml-2 text-[#0A2342] font-semibold hover:text-[#16335B] transition">
                                    <span>{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Menú desplegable -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                    
                                    <div class="py-1">
                                        <a href="{{ route('user.panel') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Mi Panel
                                        </a>
                                        <a href="{{ route('user.perfil') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Mi Perfil
                                        </a>
                                        <a href="{{ route('user.pedidos') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Mis Pedidos
                                        </a>
                                        <a href="{{ route('user.favoritos') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            Mis Favoritos
                                        </a>
                                        <hr class="my-1">
                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Cerrar sesión
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        @if(!auth()->check() || (auth()->user() && !auth()->user()->is_admin))
            @php($categoriasFooter = \App\Models\Categoria::all())
            @include('layouts.footer', ['categorias' => $categoriasFooter])
        @endif
        @stack('scripts')
    </body>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('buscador-libros');
        const resultados = document.getElementById('resultados-busqueda');
        if (!input || !resultados) return;
        let timeout = null;

        input.addEventListener('input', function () {
            clearTimeout(timeout);
            const q = this.value.trim();
            if (q.length < 2) {
                resultados.innerHTML = '';
                resultados.classList.add('hidden');
                return;
            }
            timeout = setTimeout(() => {
                fetch(`/buscar-ajax?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.length) {
                            resultados.innerHTML = '<div class="px-4 py-2 text-gray-500">Sin resultados</div>';
                            resultados.classList.remove('hidden');
                            return;
                        }
                        resultados.innerHTML = data.map(item => `
                            <a href="${item.url}" class="flex items-center gap-3 px-4 py-2 hover:bg-[#FFF5E9] transition border-b last:border-b-0">
                                <img src="${item.imagen}" alt="${item.titulo}" class="w-10 h-14 object-cover rounded shadow">
                                <div>
                                    <div class="font-semibold text-[#0A2342]">${item.titulo}</div>
                                    <div class="text-sm text-gray-500">${item.autor}</div>
                                </div>
                            </a>
                        `).join('');
                        resultados.classList.remove('hidden');      
                    });
            }, 250);
        });

        // Ocultar resultados al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!resultados.contains(e.target) && e.target !== input) {
                resultados.classList.add('hidden');
            }
        });
    });
    </script>
</html>
