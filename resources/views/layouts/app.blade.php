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
                                <img src="{{ asset('icons/cart.svg') }}" alt="Carrito" class="w-7 h-7">
                            </a>
                            <span class="ml-2 text-[#0A2342] font-semibold">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="ml-2 px-4 py-2 rounded-lg bg-white border border-[#0A2342] text-[#0A2342] font-semibold hover:bg-gray-100 transition">Cerrar sesión</button>
                            </form>
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
