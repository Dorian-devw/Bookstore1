<!-- Sección superior: Suscripción -->
<div class="w-full bg-[#00254F] py-[120px] px-4">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="text-white text-3xl md:text-4xl font-bold mb-6 md:mb-0">Ingresa tu email para recibir<br>regalos especiales.</div>
        <form action="{{ route('suscribirse') }}" method="POST" class="flex w-full md:w-auto max-w-lg">
            @csrf
            <input type="email" name="email" required placeholder="Introduzca su correo electrónico aquí" class="flex-1 rounded-l-lg px-4 py-3 focus:outline-none text-[#00254F]" style="min-width:200px;">
            <button type="submit" class="bg-[#EAA451] rounded-r-lg px-6 flex items-center justify-center hover:bg-[#d18a36] transition">
                <img src="{{ asset('icons/email.svg') }}" alt="Regalo" class="w-6 h-6">
            </button>
        </form>
    </div>
    @if(session('success'))
        <div class="max-w-5xl mx-auto mt-4 text-green-200 font-semibold">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="max-w-5xl mx-auto mt-4 text-red-200 font-semibold">{{ $errors->first('email') }}</div>
    @endif
</div>

<!-- Sección de categorías -->
<div class="w-full bg-white py-10 px-4 border-b">
    <div class="max-w-6xl mx-auto">
        <div class="font-semibold text-[#0A2342] mb-4">+ Clasificación de libros</div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-2 gap-x-8 text-[#0A2342]">
            @foreach($categorias as $cat)
                <div>{{ $cat->nombre }}</div>
            @endforeach
        </div>
    </div>
</div>

<!-- Sección inferior reorganizada: logo | contacto | mapa -->
<div class="w-full bg-white py-10 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-start gap-8">
        <!-- Izquierda: logo, mensaje, redes -->
        <div class="flex-1 flex flex-col gap-4 items-center md:items-start">
            <div class="flex items-center gap-3">
                <img src="{{ asset('bookstore.png') }}" alt="The Flying Bookstore" class="h-14 w-auto border rounded-lg p-2 bg-white">
                <span class="font-bold text-lg text-[#0A2342]">The Flying <span class="font-normal">bookstore</span></span>
            </div>
            <div class="text-gray-600 text-sm max-w-xs">The Flying bookstore es un lugar donde la   s personas pueden encontrar sus libros favoritos de distintas categorías</div>
            <div class="flex gap-4 mt-2">
                <a href="#" target="_blank"><img src="{{ asset('icons/facebook.svg') }}" alt="Facebook" class="w-6 h-6"></a>
                <a href="#" target="_blank"><img src="{{ asset('icons/youtube.svg') }}" alt="YouTube" class="w-6 h-6"></a>
                <a href="#" target="_blank"><img src="{{ asset('icons/instagram.svg') }}" alt="Instagram" class="w-6 h-6"></a>
            </div>
        </div>
        <!-- Centro: contacto -->
        <div class="flex-1 flex flex-col items-center md:items-center gap-4">
            <div class="font-bold text-[#0A2342] text-lg mb-2">Contacto</div>
            <div class="flex items-center gap-2 text-gray-700"><span>📍</span> Calle Las Cascanueces 123</div>
            <div class="flex items-center gap-2 text-gray-700"><span>📞</span> +51 987 654 321</div>
            <div class="flex items-center gap-2 text-gray-700"><span>✉️</span> soporte@flying.bookstore</div>
        </div>
        <!-- Derecha: mapa -->
        <div class="flex-1 flex flex-col items-center md:items-end gap-4">
            <div class="mt-2 w-full max-w-xs">
                <!-- Google Maps embebido -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1423.7113558522703!2d-76.95267037420754!3d-12.04572345837201!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c68826cec0c3%3A0xf6df8bcd4e0a5fcf!2sTecsup!5e0!3m2!1ses!2spe!4v1751921930333!5m2!1ses!2spe" width="100%" height="120" style="border:0; border-radius:10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    
            </div>
        </div>
    </div>
</div>

<!-- Copyright -->
<div class="w-full bg-white border-t py-4 text-center text-gray-500 text-sm">
    The Flying Bookstore · © {{ date('Y') }} Todos los derechos reservados
</div> 