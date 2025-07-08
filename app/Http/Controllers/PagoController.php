<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class PagoController extends Controller
{
    public function mercadopago(Request $request)
    {
        SDK::setAccessToken(config('services.mercadopago.access_token'));

        $preference = new Preference();

        $item = new Item();
        $item->title = 'Compra en The Flying Bookstore';
        $item->quantity = 1;
        $item->unit_price = (float) $request->input('monto');

        $preference->items = [$item];
        $preference->back_urls = [
            'success' => route('pago.exito'),
            'failure' => route('pago.fallo'),
            'pending' => route('pago.pendiente'),
        ];
        $preference->auto_return = 'approved';
        $preference->save();

        return view('pago.mercadopago', [
            'preference' => $preference
        ]);
    }

    public function exito(Request $request)
    {
        return view('pago.exito');
    }

    public function fallo(Request $request)
    {
        return view('pago.fallo');
    }

    public function pendiente(Request $request)
    {
        return view('pago.pendiente');
    }
} 