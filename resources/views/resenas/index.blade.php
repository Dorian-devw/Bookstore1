@if($libro->resenasAprobadas()->count() > 0)
    <div class="space-y-4">
        @foreach($libro->resenasAprobadas()->with('user')->orderByDesc('created_at')->get() as $resena)
            <div class="bg-white rounded shadow p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <div class="font-semibold">{{ $resena->user->name ?? 'Usuario' }}</div>
                        <div class="text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $resena->calificacion ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
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
    <div class="bg-white rounded shadow p-6 text-center text-gray-500">
        <p>No hay reseñas para este libro aún.</p>
        @auth
            <p class="mt-2">¡Sé el primero en escribir una reseña!</p>
        @endauth
    </div>
@endif 