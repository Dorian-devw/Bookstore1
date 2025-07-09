@if($libro->resenasAprobadas()->count() > 0)
    <div class="space-y-4 mb-8">
        <h3 class="text-xl font-semibold mb-4">Reseñas de usuarios ({{ $libro->resenasAprobadas()->count() }})</h3>
        @foreach($libro->resenasAprobadas()->with('user')->orderByDesc('created_at')->get() as $resena)
            <div class="bg-white rounded shadow p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="font-semibold">{{ $resena->user->name ?? 'Usuario' }}</div>
                        <div class="text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $resena->calificacion ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                            <span class="text-sm text-gray-500 ml-2">{{ $resena->calificacion }}/5</span>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">{{ $resena->created_at->format('d/m/Y') }}</div>
                </div>
                @if($resena->comentario)
                    <p class="text-gray-700">{{ $resena->comentario }}</p>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded shadow p-6 text-center text-gray-500 mb-8">
        <p>No hay reseñas para este libro aún.</p>
        @auth
            <p class="mt-2">¡Sé el primero en escribir una reseña!</p>
        @endauth
    </div>
@endif

@auth
    @php
        $resenaExistente = \App\Models\Resena::where('user_id', auth()->id())
            ->where('libro_id', $libro->id)
            ->first();
    @endphp
    
    @if($resenaExistente)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-semibold text-blue-800">Tu reseña</span>
            </div>
            <div class="text-blue-700 text-sm">
                @if($resenaExistente->estado === 'pendiente')
                    Tu reseña está <strong>pendiente de aprobación</strong>.
                @elseif($resenaExistente->estado === 'rechazado')
                    Tu reseña fue <strong>rechazada</strong>.
                @else
                    Tu reseña fue <strong>aprobada</strong>.
                @endif
                <a href="{{ route('resenas.edit', $resenaExistente->id) }}" class="text-blue-600 hover:underline ml-2">Editar reseña</a>
            </div>
        </div>
    @else
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Escribe tu reseña</h3>
            <form action="{{ route('resenas.store', $libro->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block font-semibold mb-2">Calificación</label>
                    <div class="flex gap-2 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="flex items-center gap-1 cursor-pointer">
                                <input type="radio" name="calificacion" value="{{ $i }}" class="hidden" required>
                                <span class="text-2xl text-gray-300 hover:text-yellow-400 transition-colors" 
                                      onclick="selectRating({{ $i }})">★</span>
                            </label>
                        @endfor
                    </div>
                    <div class="text-sm text-gray-600">Haz clic en las estrellas para calificar</div>
                    @error('calificacion')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div>
                    <label class="block font-semibold mb-2">Comentario (opcional)</label>
                    <textarea name="comentario" rows="4" 
                              class="w-full border rounded p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Comparte tu opinión sobre este libro...">{{ old('comentario') }}</textarea>
                    @error('comentario')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Enviar Reseña
                    </button>
                </div>
            </form>
        </div>
    @endif
@else
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
        <p class="text-gray-600 mb-2">¿Te gustó este libro?</p>
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Inicia sesión para escribir una reseña</a>
    </div>
@endauth

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