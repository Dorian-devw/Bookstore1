<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suscriptor;
use App\Mail\SuscripcionBienvenida;
use Illuminate\Support\Facades\Mail;
use App\Models\Cupon;

class SuscriptorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:suscriptores,email',
        ]);
        $suscriptor = Suscriptor::create([
            'email' => $request->email,
        ]);

        // Buscar un cupón válido (el primero disponible)
        $cupon = Cupon::first();
        if ($cupon) {
            Mail::to($suscriptor->email)->send(new SuscripcionBienvenida($cupon));
        }

        return back()->with('success', '¡Gracias por suscribirte! Revisa tu correo para recibir tu beneficio.');
    }
}
