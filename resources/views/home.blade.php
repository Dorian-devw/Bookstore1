@extends('layouts.app')

@section('content')

<div class="w-full bg-[#FCFCF6] py-16 relative overflow-hidden">
    <!-- SVG de fondo -->
    <img src="{{ asset('images/waveElement.svg') }}"
         alt="Decoración"
         class="absolute inset-0 w-full h-full object-cover z-0 pointer-events-none select-none transition-transform duration-700 ease-in-out"
         id="waveElementBg"
         draggable="false">
    <img src="{{ asset('images/Ellipse 49.svg') }}" alt="Círculo naranja" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] z-0 pointer-events-none select-none opacity-40" draggable="false">

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="swiper mySwiper w-full">
            <div class="swiper-wrapper">
                @foreach($masVendidos as $index => $libro)
                    @php
                        $randomAngle = rand(0, 360);
                    @endphp
                    <div class="swiper-slide w-full flex flex-col md:flex-row items-center justify-between px-8 py-12 min-h-[500px]">
                        <!-- Columna izquierda: Información del libro -->
                        <div class="flex-1 flex flex-col justify-center z-10 md:pr-16 text-left h-full">
                            <div class="flex flex-col justify-center h-full mt-8 md:mt-0">
                                <h2 class="text-4xl font-bold text-[#0A2342] mb-2">{{ $libro->titulo }}</h2>
                                <div class="text-gray-500 mb-2">
                                    {{ $libro->autor->nombre }}
                                    <span class="text-xs bg-gray-200 rounded px-2 py-1 ml-2"># {{ $libro->categoria->nombre }}</span>
                                </div>
                                <p class="text-gray-700 mb-4 w-full break-words">{{ $libro->descripcion }}</p>
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="text-2xl font-bold text-[#0A2342]">S/ {{ number_format($libro->precio, 2) }}</span>
                                </div>
                                <div class="flex gap-3">
                                    @if(Auth::check())
                                        <form method="POST" action="{{ route('carrito.agregar') }}" onsubmit="return true;">
                                            @csrf
                                            <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                                            <input type="hidden" name="cantidad" value="1">
                                            <input type="hidden" name="redirect_to_carrito" value="1">
                                            <button type="submit" class="px-6 py-2 rounded-lg bg-[#0A2342] text-white font-semibold hover:bg-[#16335B] transition">Comprar ahora</button>
                                        </form>
                                    @else
                                        <a href="{{ route('carrito.advertencia_login') }}" class="px-6 py-2 rounded-lg bg-[#0A2342] text-white font-semibold hover:bg-[#16335B] transition">Comprar ahora</a>
                                    @endif
                                    <a href="{{ route('libro.detalle', $libro->id) }}" class="px-6 py-2 rounded-lg border border-[#0A2342] text-[#0A2342] font-semibold hover:bg-[#0A2342] hover:text-white transition">Ver detalles</a>
                                </div>
                            </div>
                        </div>

                        <!-- Columna derecha: Imagen del libro con fondo decorativo -->
                        <div class="flex-1 flex justify-end items-center relative z-10 min-h-[420px] md:pl-12">
                            <!-- Fondo circular decorativo -->
                            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#F9B233] opacity-30 rounded-full -z-10"></div>
                            <!-- Imagen del libro como enlace al detalle -->
                            <a href="{{ route('libro.detalle', $libro->id) }}">
                                <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png') }}"
                                    alt="{{ $libro->titulo }}"
                                    class="w-[280px] h-[420px] object-cover rounded-xl shadow-2xl relative z-20">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Sección informativa de beneficios -->
<div class="w-full bg-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl mb-3" style="background-color: #FFF5E9;">
                    <img src="{{ asset('icons/rayo.svg') }}" alt="Rápidez" class="w-7 h-7" style="color: #EAA451; fill: #EAA451;">
                </div>
                <h3 class="font-bold text-lg text-[#0A2342] mb-1">Rápidez</h3>
                <p class="text-gray-500 text-sm">Encuentra de forma rápida toda nuestra colección de libros que tenemos para ti</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl mb-3" style="background-color: #FFF5E9;">
                    <img src="{{ asset('icons/escudo.svg') }}" alt="Seguridad" class="w-7 h-7" style="color: #EAA451; fill: #EAA451;">
                </div>
                <h3 class="font-bold text-lg text-[#0A2342] mb-1">Seguridad</h3>
                <p class="text-gray-500 text-sm">Tenemos y preservamos tus datos personales de la forma más segura.</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl mb-3" style="background-color: #FFF5E9;">
                    <img src="{{ asset('icons/like.svg') }}" alt="Aceptación" class="w-7 h-7" style="color: #EAA451; fill: #EAA451;">
                </div>
                <h3 class="font-bold text-lg text-[#0A2342] mb-1">Aceptación</h3>
                <p class="text-gray-500 text-sm">Recibimos muchos reconocimientos y premios.</p>
            </div>
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl mb-3" style="background-color: #FFF5E9;">
                    <img src="{{ asset('icons/star.svg') }}" alt="Favoritos" class="w-7 h-7" style="color: #EAA451; fill: #EAA451;">
                </div>
                <h3 class="font-bold text-lg text-[#0A2342] mb-1">Favoritos</h3>
                <p class="text-gray-500 text-sm">Con nuestra sección de favoritos nunca te perderás de los mejor para ti</p>
            </div>
        </div>
    </div>
</div>



<!-- NUEVOS LIBROS LANZADOS -->
<div class="w-full bg-[#FBFBFB] py-16">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">Nuevos libros lanzados</h2>
        <p class="text-center text-gray-500 mb-8">Desde nuestro último libro, nuestro catálogo se expande y recibimos mucha aceptación por parte del público para todas las edades.</p>

        <div class="relative">
            <!-- Cambios aquí: overflow-visible y paddings para ver los laterales -->
            <div class="swiper nuevosSwiper overflow-visible px-6">
                <div class="swiper-wrapper">
                    @foreach($nuevosLanzamientos as $libro)
                    <!-- Slides con escala inicial pequeña -->
                    <div class="swiper-slide !w-[180px] flex flex-col items-center justify-end transition-all duration-300 cursor-pointer scale-90 opacity-70">
                        <a href="{{ route('libro.detalle', $libro->id) }}" class="block">
                            <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.jpg') }}"
                                alt="{{ $libro->titulo }}"
                                class="mx-auto rounded-lg shadow-lg object-cover transition-all duration-300 w-36 h-52 md:w-40 md:h-60">
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Flechas -->
                <div class="swiper-button-prev !left-0 !top-1/2 !-translate-y-1/2 bg-white shadow rounded-full w-10 h-10 flex items-center justify-center z-20"></div>
                <div class="swiper-button-next !right-0 !top-1/2 !-translate-y-1/2 bg-white shadow rounded-full w-10 h-10 flex items-center justify-center z-20"></div>
            </div>

            <!-- Info del libro central -->
            <div id="nuevoLibroInfo" class="mt-8 text-center transition-all duration-300">
                <!-- Rellenado por JS -->
            </div>
        </div>
    </div>
</div>

<!-- SLIDE DE CATEGORÍAS CON LIBRO MÁS VENDIDO -->
<div class="w-full bg-[#FBFBFB] py-16">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-2">Catálogo de productos</h2>
        <p class="text-center text-gray-500 mb-8">Contamos con una diversa cantidad de libros, tanto para niños como para grandes adultos.</p>
        <div class="swiper catalogoSwiper">
            <div class="swiper-wrapper">
                @foreach($categoriasConLibro as $cat)
                <div class="swiper-slide flex flex-col items-center">
                    <a href="{{ route('catalogo', ['categoria' => $cat['id']]) }}" class="group flex flex-col items-center">
                        <div class="w-40 h-40 rounded-full overflow-hidden shadow-lg mb-4 flex items-center justify-center bg-gray-100 group-hover:ring-4 group-hover:ring-[#EAA451] transition">
                            <img src="{{ $cat['libro'] && $cat['libro']->imagen ? asset($cat['libro']->imagen) : asset('images/default-book.png') }}"
                                 alt="{{ $cat['nombre'] }}"
                                 class="object-cover w-full h-full">
                        </div>
                        <div class="font-bold text-lg text-[#0A2342] group-hover:text-[#EAA451] transition">{{ $cat['nombre'] }}</div>
                        @if($cat['libro'])
                            <div class="text-sm text-gray-500 text-center mt-1">{{ $cat['libro']->titulo }}</div>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
            <!-- Flechas -->
            <div class="swiper-button-prev catalogo-prev !left-0 !top-1/2 !-translate-y-1/2 bg-white shadow rounded-full w-10 h-10 flex items-center justify-center z-20"></div>
            <div class="swiper-button-next catalogo-next !right-0 !top-1/2 !-translate-y-1/2 bg-white shadow rounded-full w-10 h-10 flex items-center justify-center z-20"></div>
        </div>
    </div>
</div>



<!-- Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Swiper principal (mas vendidos) se mantiene igual
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 1,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            speed: 700,
            allowTouchMove: true,
            on: {
                realIndexChange: function () {
                    const activeIndex = this.realIndex;
                    const slides = document.querySelectorAll('.swiper-slide');
                    const currentSlide = slides[activeIndex % slides.length];
                    const angle = currentSlide?.dataset.rotate ?? 0;

                    const bg = document.getElementById('waveElementBg');
                    if (bg) {
                        bg.style.transition = 'transform 0.6s ease';
                        bg.style.transform = `rotate(${angle}deg)`;
                    }
                },
                init: function () {
                    const firstSlide = document.querySelector('.swiper-slide');
                    const angle = firstSlide?.dataset.rotate ?? 0;
                    const bg = document.getElementById('waveElementBg');
                    if (bg) {
                        bg.style.transition = 'transform 0.6s ease';
                        bg.style.transform = `rotate(${angle}deg)`;
                    }
                }
            }
        });

        // Swiper para nuevos lanzamientos (ajustado)
        const nuevosSwiper = new Swiper('.nuevosSwiper', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 24,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                init: function () {
                    updateNuevoLibroInfo(this);
                },
                slideChange: function () {
                    updateNuevoLibroInfo(this);
                }
            }
        });

        // Swiper para catálogo de categorías
        const catalogoSwiper = new Swiper('.catalogoSwiper', {
            slidesPerView: 3,
            centeredSlides: true,
            spaceBetween: 32,
            loop: true,
            navigation: {
                nextEl: '.catalogo-next',
                prevEl: '.catalogo-prev',
            },
            breakpoints: {
                640: { slidesPerView: 3 },
                1024: { slidesPerView: 5 }
            }
        });

        // Mostrar info del libro central y destacar visualmente
        function updateNuevoLibroInfo(swiper) {
            const slides = swiper.slides;
            const realIndex = swiper.realIndex;
            const libro = @json($nuevosLanzamientos)[realIndex];
            if (!libro) return;

            slides.forEach((slide, index) => {
                if (index === swiper.activeIndex) {
                    slide.classList.add('scale-100', 'opacity-100');
                    slide.classList.remove('scale-90', 'opacity-70');
                } else {
                    slide.classList.remove('scale-100', 'opacity-100');
                    slide.classList.add('scale-90', 'opacity-70');
                }
            });

            const infoDiv = document.getElementById('nuevoLibroInfo');
            infoDiv.innerHTML = `
                <h3 class="text-lg md:text-xl font-bold mb-1">${libro.titulo}</h3>
                <div class="text-[#EAA451] font-semibold text-lg mb-3">S/ ${parseFloat(libro.precio).toFixed(2)}</div>
                <form method="POST" action="/carrito/agregar/${libro.id}">
                    @csrf
                    
                </form>
            `;
        }
    });
</script>


@push('styles')
<style>
@keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.animate-scroll {
  animation: scroll 20s linear infinite;
}
.nuevosSwiper .swiper-slide {
    width: 160px;
    opacity: 0.5;
    filter: blur(1px);
    transition: all 0.3s;
}
.nuevosSwiper .swiper-slide.swiper-slide-active {
    width: 220px;
    opacity: 1;
    filter: none;
    z-index: 10;
}
.nuevosSwiper .swiper-button-next, .nuevosSwiper .swiper-button-prev {
    color: #EAA451;
    border: none;
}
.catalogoSwiper .swiper-slide {
    transition: transform 0.3s, opacity 0.3s;
    opacity: 0.6;
    transform: scale(0.9);
}
.catalogoSwiper .swiper-slide.swiper-slide-active {
    opacity: 1;
    transform: scale(1.05);
    z-index: 10;
}
</style>
@endpush
@endsection
