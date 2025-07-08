@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Escribir Reseña</h1>
    
    <a href="{{ route('libro.detalle', $libro->id) }}" class="text-blue-700 hover:underline mb-4 inline-block">&larr; Volver al libro</a>
    
    <div class="bg-white rounded shadow p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">{{ $libro->titulo }}</h2>
            <p class="text-gray-600">{{ $libro->autor->nombre ?? '' }}</p>
        </div>
        
        <form action="{{ route('resenas.store', $libro->id) }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block font-semibold mb-2">Calificación</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <label class="flex items-center gap-1 cursor-pointer">
                            <input type="radio" name="calificacion" value="{{ $i }}" class="hidden" required>
                            <span class="text-2xl text-gray-300 hover:text-yellow-400 transition-colors" 
                                  onclick="selectRating({{ $i }})">★</span>
                        </label>
                    @endfor
                </div>
                <div class="text-sm text-gray-600 mt-1">Haz clic en las estrellas para calificar</div>
                @error('calificacion')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div>
                <label class="block font-semibold mb-2">Comentario (opcional)</label>
                <textarea name="comentario" rows="4" 
                          class="w-full border rounded p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Comparte tu opinión sobre este libro...">{{ old('comentario') }}</textarea>
                @error('comentario')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Enviar Reseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function selectRating(rating) {
    // Limpiar todas las estrellas
    document.querySelectorAll('input[name="calificacion"]').forEach((input, index) => {
        const star = input.nextElementSibling;
        star.classList.remove('text-yellow-400');
        star.classList.add('text-gray-300');
    });
    
    // Marcar las estrellas seleccionadas
    for (let i = 0; i < rating; i++) {
        const input = document.querySelectorAll('input[name="calificacion"]')[i];
        const star = input.nextElementSibling;
        star.classList.remove('text-gray-300');
        star.classList.add('text-yellow-400');
    }
    
    // Marcar el radio button
    document.querySelector(`input[name="calificacion"][value="${rating}"]`).checked = true;
}

// Marcar estrellas al cargar si hay valor previo
document.addEventListener('DOMContentLoaded', function() {
    const selectedRating = document.querySelector('input[name="calificacion"]:checked');
    if (selectedRating) {
        selectRating(parseInt(selectedRating.value));
    }
});
</script>
@endsection 