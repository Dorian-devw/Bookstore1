<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Pedido;
use App\Models\Carrito;
use App\Models\Cupon;
use App\Mail\PedidoConfirmado;

class PedidoController extends Controller
{
    // Procesar la compra (POST)
    public function procesarCompra(Request $request)
    {
        // Validar y obtener datos
        $user = Auth::user();
        $carrito = Carrito::where('user_id', $user->id)->get();
        if ($carrito->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío.');
        }
        // Calcular totales y cupon
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item->libro->precio * $item->cantidad;
        }
        $descuento = 0;
        $cupon = null;
        if ($request->cupon_codigo) {
            $cupon = Cupon::where('codigo', $request->cupon_codigo)->first();
            if ($cupon) {
                $descuento = $cupon->descuento;
            }
        }
        $totalFinal = $total + 15 - $descuento; // 15 es el envío
        // Crear el pedido
        $pedido = Pedido::create([
            'user_id' => $user->id,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'direccion' => $request->direccion_completa,
            'telefono' => $request->telefono,
            'fecha_entrega' => $request->fecha_entrega,
            'metodo_pago' => $request->metodo_pago,
            'total' => $totalFinal,
            'cupon_id' => $cupon ? $cupon->id : null,
        ]);
        // Guardar detalles del pedido
        foreach ($carrito as $item) {
            $pedido->detalles()->create([
                'libro_id' => $item->libro_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->libro->precio,
            ]);
        }
        // Limpiar carrito
        Carrito::where('user_id', $user->id)->delete();
        // Enviar correo de confirmación solo si hay email
        if ($pedido->email) {
            Mail::to($pedido->email)->send(new PedidoConfirmado($pedido));
        }
        // Redirigir a compra realizada
        return redirect()->route('compra.realizada', $pedido->id);
    }

    // Mostrar compra realizada
    public function compraRealizada(Pedido $pedido)
    {
        $libros = $pedido->detalles; // Relación detalles
        $cupon = $pedido->cupon ?? null;
        return view('compra_realizada', compact('pedido', 'libros', 'cupon'));
    }

    // Descargar comprobante (PDF)
    public function descargarComprobante(Pedido $pedido)
    {
        $user = Auth::user();
        // Solo el dueño o el admin pueden ver el comprobante
        if ($pedido->user_id !== $user->id && !($user->is_admin ?? false)) {
            abort(403, 'No tienes permiso para ver este comprobante.');
        }
        $libros = $pedido->detalles;
        $cupon = $pedido->cupon ?? null;
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pedidos.comprobante', compact('pedido', 'libros', 'cupon'));
        return $pdf->download('comprobante-pedido-'.$pedido->id.'.pdf');
    }

    // Gestión de pedidos del cliente
    public function misPedidos()
    {
        $user = Auth::user();
        $pedidos = Pedido::where('user_id', $user->id)->latest()->get();
        return view('cliente.pedidos', compact('pedidos'));
    }
} 