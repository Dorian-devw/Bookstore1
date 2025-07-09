<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;

class VerificarReservas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $session_id = session()->getId();
        
        // Renovar reservas activas del usuario actual
        Carrito::where('reservado_hasta', '>', now())
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->update(['reservado_hasta' => now()->addMinutes(30)]);
        
        // Limpiar reservas expiradas de otros usuarios
        Carrito::where('reservado_hasta', '<', now())->delete();
        
        return $next($request);
    }
}
