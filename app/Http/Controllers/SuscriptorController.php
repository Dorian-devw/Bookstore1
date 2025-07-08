<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suscriptor;

class SuscriptorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:suscriptores,email',
        ]);
        Suscriptor::create([
            'email' => $request->email,
        ]);
        return back()->with('success', '¡Gracias por suscribirte!');
    }
}
