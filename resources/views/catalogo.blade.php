@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Catálogo de Libros</h1>
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filtros -->
        <form method="GET" class="md:w-1/4 bg-white rounded-lg shadow p-4 mb-6 md:mb-0">
            <h2 class="text-xl font-semibold mb-4">Filtros</h2>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Categoría</label>
                <select name="categoria" class="w-full border rounded p-2">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @if(request('categoria') == $cat->id) selected @endif>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Idioma</label>
                <select name="idioma" class="w-full border rounded p-2">
                    <option value="">Todos</option>
                    @foreach($idiomas as $idioma)
                        <option value="{{ $idioma }}" @if(request('idioma') == $idioma) selected @endif>{{ ucfirst($idioma) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Precio</label>
                <div class="flex gap-2">
                    <input type="number" name="precio_min" placeholder="Mín" value="{{ request('precio_min') }}" class="w-1/2 border rounded p-2">
                    <input type="number" name="precio_max" placeholder="Máx" value="{{ request('precio_max') }}" class="w-1/2 border rounded p-2">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Valoración mínima</label>
                <input type="number" step="0.1" min="0" max="5" name="valoracion" value="{{ request('valoracion') }}" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="w-full bg-[#EAA451] text-white py-2 rounded hover:bg-orange-500 transition-colors">Filtrar</button>
        </form>

        <!-- Listado de libros -->
        <div class="md:w-3/4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($libros as $libro)
                    <div class="bg-white rounded-xl shadow flex flex-col items-center p-3 pb-16 relative group transition-all duration-200 hover:shadow-xl hover:ring-2 hover:ring-[#EAA451]">
                        <!-- Botón de favorito -->
                        @auth
                            <button onclick="toggleFavorito({{ $libro->id }}, this)" 
                                    class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-white shadow border border-gray-200 hover:bg-red-50 hover:border-red-300 transition z-10 {{ auth()->user()->favoritos()->where('libro_id', $libro->id)->exists() ? 'bg-red-50 border-red-300' : '' }}"
                                    data-libro-id="{{ $libro->id }}">
                                <img src="{{ asset('icons/favorito.svg') }}" alt="Favorito" class="w-5 h-5 {{ auth()->user()->favoritos()->where('libro_id', $libro->id)->exists() ? 'text-red-500' : 'text-gray-400' }}">
                            </button>
                        @endauth
                        
                        <a href="{{ route('libro.detalle', $libro->id) }}" class="block w-full flex justify-center mb-2">
                            <img src="{{ $libro->imagen ? asset($libro->imagen) : asset('images/default-book.png') }}" alt="{{ $libro->titulo }}" class="w-32 h-48 object-cover rounded-lg shadow transition-transform duration-200 group-hover:scale-105">
                        </a>
                        <div class="flex-1 w-full flex flex-col items-center justify-between">
                            <div class="font-semibold text-center text-[#16183E] line-clamp-2 min-h-[48px]">{{ $libro->titulo }}</div>
                            <div class="text-sm text-gray-500 mb-1">{{ $libro->autor->nombre ?? '' }}</div>
                            
                            <!-- Calificación con estrellas -->
                            <div class="flex items-center gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <img src="{{ asset('icons/star.svg') }}" 
                                         alt="Estrella" 
                                         class="w-4 h-4 {{ $i <= $libro->valoracion ? 'text-yellow-400' : 'text-gray-300' }}"
                                         style="filter: {{ $i <= $libro->valoracion ? 'brightness(1) saturate(1)' : 'brightness(0.3) saturate(0)' }}">
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">({{ number_format($libro->valoracion, 1) }})</span>
                            </div>
                            
                            <div class="text-blue-900 font-bold text-lg mb-2">S/ {{ number_format($libro->precio, 2) }}</div>
                        </div>
                        <form method="POST" action="{{ route('carrito.agregar') }}" class="absolute left-0 right-0 bottom-3 flex justify-center z-20">
                            @csrf
                            <input type="hidden" name="libro_id" value="{{ $libro->id }}">
                            <div class="flex items-center bg-white rounded-full shadow-lg border border-gray-200 overflow-hidden group-hover:shadow-xl transition-all duration-200 backdrop-blur-sm bg-white/95">
                                <button type="button" onclick="decrementarCantidad(this)" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" name="cantidad" value="1" min="1" max="{{ $libro->stock }}" class="w-12 h-8 text-center text-sm font-medium border-0 focus:ring-0 focus:outline-none bg-white">
                                <button type="button" onclick="incrementarCantidad(this)" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors text-gray-600 hover:text-gray-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-[#EAA451] hover:bg-orange-500 transition-colors text-white">
                                    <img src="{{ asset('icons/carritoblanco.svg') }}" alt="Agregar al carrito" class="w-4 h-4">
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="col-span-2 md:col-span-4 text-center text-gray-500">No se encontraron libros con los filtros seleccionados.</div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $libros->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Notificación de favorito -->
<div id="favorito-notification" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span id="favorito-message">Añadido a favoritos</span>
    </div>
</div>

<script>
function toggleFavorito(libroId, button) {
    const isFavorito = button.classList.contains('bg-red-50');
    const action = isFavorito ? 'remove' : 'add';
    
    console.log('Enviando petición favoritos:', { libroId, action, tipo: typeof libroId });
    
    // Verificar que libroId no sea undefined o null
    if (!libroId) {
        console.error('Error: libroId es undefined o null');
        showNotification('Error: ID de libro no válido', 'error');
        return;
    }
    
    // Usar FormData en lugar de JSON para evitar problemas de CSRF
    const formData = new FormData();
    formData.append('libro_id', libroId);
    formData.append('action', action);
    formData.append('_token', '{{ csrf_token() }}');
    
    // Verificar que los datos se agregaron correctamente
    console.log('FormData contents:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    fetch('{{ route("user.favoritos.store") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Cambiar apariencia del botón
            if (action === 'add') {
                button.classList.add('bg-red-50', 'border-red-300');
                button.querySelector('img').classList.add('text-red-500');
                button.querySelector('img').classList.remove('text-gray-400');
                showNotification('Añadido a favoritos');
            } else {
                button.classList.remove('bg-red-50', 'border-red-300');
                button.querySelector('img').classList.remove('text-red-500');
                button.querySelector('img').classList.add('text-gray-400');
                showNotification('Eliminado de favoritos');
            }
        } else {
            showNotification('Error: ' + (data.message || 'Error desconocido'), 'error');
        }
    })
    .catch(error => {
        console.error('Error en fetch:', error);
        showNotification('Error al procesar la solicitud: ' + error.message, 'error');
    });
}

function showNotification(message, type = 'success') {
    const notification = document.getElementById('favorito-notification');
    const messageElement = document.getElementById('favorito-message');
    
    // Cambiar color según el tipo
    if (type === 'error') {
        notification.classList.remove('bg-green-500');
        notification.classList.add('bg-red-500');
    } else {
        notification.classList.remove('bg-red-500');
        notification.classList.add('bg-green-500');
    }
    
    messageElement.textContent = message;
    
    // Mostrar notificación
    notification.classList.remove('translate-x-full');
    
    // Ocultar después de 3 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
    }, 3000);
}

function incrementarCantidad(button) {
    const input = button.parentElement.querySelector('input[type="number"]');
    const max = parseInt(input.getAttribute('max'));
    let valor = parseInt(input.value) || 1;
    
    if (valor < max) {
        input.value = valor + 1;
    } else {
        input.value = max;
    }
    
    // Efecto visual de feedback
    button.classList.add('scale-95');
    setTimeout(() => button.classList.remove('scale-95'), 150);
}

function decrementarCantidad(button) {
    const input = button.parentElement.querySelector('input[type="number"]');
    const min = parseInt(input.getAttribute('min'));
    let valor = parseInt(input.value) || 1;
    
    if (valor > min) {
        input.value = valor - 1;
    } else {
        input.value = min;
    }
    
    // Efecto visual de feedback
    button.classList.add('scale-95');
    setTimeout(() => button.classList.remove('scale-95'), 150);
}

// Manejar envío del formulario del carrito
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[action*="carrito.agregar"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            
            // Mostrar loading
            submitButton.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            `;
            submitButton.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Libro añadido al carrito correctamente');
                    
                    // Efecto visual en el botón
                    submitButton.classList.add('bg-green-500');
                    setTimeout(() => {
                        submitButton.classList.remove('bg-green-500');
                    }, 1000);
                } else {
                    showNotification(data.message || 'Error al añadir al carrito', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error al procesar la solicitud', 'error');
            })
            .finally(() => {
                // Restaurar botón
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
            });
        });
    });
});
</script>
@endsection 