<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/admin">
                        <x-application-logo class="block h-14 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>
            @if(Auth::check() && Auth::user()->email === 'admin@flying-bookstore.com')
                <div class="relative flex items-center gap-4" x-data="{ open: false }">
                    <button @click="open = !open" class="font-semibold text-gray-800 focus:outline-none flex items-center gap-2">
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <!-- Fondo para cerrar al hacer click fuera -->
                    <div x-show="open" @click="open = false" class="fixed inset-0 z-40" style="background: transparent;"></div>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50" style="min-width: 10rem;">
                        <form method="POST" action="{{ route('logout') }}" onsubmit="setTimeout(function(){ window.location.href='/login'; }, 100);">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                <!-- Buscador y carrito solo para usuarios/cliente -->
                <div class="flex items-center gap-4">
                    <div class="relative w-64">
                        <input
                            id="buscador-libros"
                            type="text"
                            name="q"
                            placeholder="Buscar libro o autor..."
                            autocomplete="off"
                            class="border border-gray-300 rounded-lg px-3 pr-10 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#EAA451]"
                            style="padding-right: 2.5rem;"
                        >
                        
                        <div id="resultados-busqueda" class="absolute left-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden"></div>
                    </div>
                    <a href="{{ route('carrito.index') }}" class="text-[#0A2342] hover:text-[#16335B]">
                        <img src="{{ asset('icons/cart.svg') }}" alt="Carrito" class="w-7 h-7">
                    </a>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('buscador-libros');
    const resultados = document.getElementById('resultados-busqueda');
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
