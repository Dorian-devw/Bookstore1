<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Libro;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Pago;
use App\Models\Direccion;
use App\Models\Cupon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoConfirmado;

class CarritoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $session_id = session()->getId();
        $carrito = Carrito::with('libro')
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->get();
        $total = $carrito->sum(fn($item) => $item->libro->precio * $item->cantidad);
        
        $descuento = 0;
        $cupon = null;
        
        // Procesar cupón si se envió
        if ($request->filled('cupon_codigo')) {
            $cupon = Cupon::buscarPorCodigo($request->cupon_codigo);
            if ($cupon && $cupon->esValido($total)) {
                $descuento = $cupon->calcularDescuento($total);
                session(['descuento' => $descuento, 'cupon_codigo' => $request->cupon_codigo]);
            } else {
                session()->forget(['descuento', 'cupon_codigo']);
                return redirect()->route('carrito.index')->with('error', 'Cupón no válido o expirado');
            }
        } else {
            // Si no se envió cupón, usar el de la sesión si existe
            if (session('descuento') && session('cupon_codigo')) {
                $cupon = Cupon::buscarPorCodigo(session('cupon_codigo'));
                if ($cupon && $cupon->esValido($total)) {
                    $descuento = session('descuento');
                } else {
                    session()->forget(['descuento', 'cupon_codigo']);
                }
            }
        }
        
        return view('carrito', compact('carrito', 'total', 'descuento', 'cupon'));
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'libro_id' => 'required|exists:libros,id',
            'cantidad' => 'required|integer|min:1',
        ]);
        $user = Auth::user();
        $session_id = session()->getId();
        $carrito = Carrito::where('libro_id', $request->libro_id)
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->first();
        if ($carrito) {
            $carrito->cantidad += $request->cantidad;
            $carrito->save();
        } else {
            Carrito::create([
                'user_id' => $user->id ?? null,
                'session_id' => $user ? null : $session_id,
                'libro_id' => $request->libro_id,
                'cantidad' => $request->cantidad,
                'reservado_hasta' => now()->addMinutes(30),
            ]);
        }
        return redirect()->route('carrito.index')->with('success', '¡Libro añadido al carrito exitosamente!');
    }

    public function eliminar($id)
    {
        $user = Auth::user();
        $session_id = session()->getId();
        $carrito = Carrito::where('id', $id)
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->firstOrFail();
        $carrito->delete();
        return redirect()->route('carrito.index')->with('success', 'Libro eliminado del carrito');
    }

    public function confirmar()
    {
        $user = Auth::user();
        $session_id = session()->getId();
        $carrito = Carrito::with('libro')
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->get();
        $direcciones = $user ? Direccion::where('user_id', $user->id)->get() : collect();
        $total = $carrito->sum(fn($item) => $item->libro->precio * $item->cantidad);
        $descuento = session('descuento') ?? 0;
        $cupon = session('cupon_codigo') ?? null;
        return view('confirmar_compra', compact('carrito', 'total', 'direcciones', 'descuento', 'cupon'));
    }

    public function procesarCompra(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|in:tarjeta,yape,transferencia',
            'direccion_id' => 'nullable|exists:direcciones,id',
            'cupon_codigo' => 'nullable|string',
            // Campos para usuarios no registrados
            'nombre' => 'required_if:user_id,null|string|max:255',
            'email' => 'required_if:user_id,null|email|max:255',
            'telefono' => 'required_if:user_id,null|string|max:20',
            'direccion_completa' => 'required_if:user_id,null|string|max:500',
        ]);

        $user = Auth::user();
        $session_id = session()->getId();
        $carrito = Carrito::with('libro')
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->get();

        if ($carrito->isEmpty()) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío');
        }

        // Calcular subtotal
        $subtotal = $carrito->sum(fn($item) => $item->libro->precio * $item->cantidad);
        $descuento = 0;
        $cupon = null;

        // Validar cupón si se proporcionó
        if ($request->filled('cupon_codigo')) {
            $cupon = Cupon::buscarPorCodigo($request->cupon_codigo);
            if (!$cupon) {
                return back()->with('error', 'Cupón no válido');
            }
            if (!$cupon->esValido($subtotal)) {
                return back()->with('error', 'Cupón no válido o expirado');
            }
            $descuento = $cupon->calcularDescuento($subtotal);
        }

        $total = $subtotal - $descuento;

        // Crear pedido
        $pedido = Pedido::create([
            'user_id' => $user?->id,
            'estado' => 'pendiente',
            'total' => $total,
            'metodo_pago' => $request->metodo_pago,
            'fecha' => now(),
            'cupon_id' => $cupon?->id,
            'descuento' => $descuento,
            // Datos para usuarios no registrados
            'cliente_nombre' => $user ? $user->name : $request->nombre,
            'cliente_email' => $user ? $user->email : $request->email,
            'cliente_telefono' => $user ? ($user->telefono ?? '') : $request->telefono,
            'direccion_entrega' => $user ? '' : $request->direccion_completa,
            'session_id' => $user ? null : $session_id,
        ]);

        // Crear detalles del pedido
        foreach ($carrito as $item) {
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'libro_id' => $item->libro_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->libro->precio,
            ]);

            // Actualizar stock
            $item->libro->decrement('stock', $item->cantidad);
        }

        // Crear pago
        Pago::create([
            'pedido_id' => $pedido->id,
            'monto' => $total,
            'metodo' => $request->metodo_pago,
            'estado' => 'pendiente',
        ]);

        // Incrementar uso del cupón si se usó
        if ($cupon) {
            $cupon->incrementarUso();
        }

        // Limpiar carrito
        $carrito->each->delete();

        // Enviar email de confirmación
        try {
            $email = $user ? $user->email : $request->email;
            Mail::to($email)->send(new PedidoConfirmado($pedido));
        } catch (\Exception $e) {
            // Log error pero no fallar la compra
            \Log::error('Error enviando email de confirmación: ' . $e->getMessage());
        }

        // Redirigir según si es usuario registrado o no
        if ($user) {
        return redirect()->route('user.pedido.detalle', $pedido->id)->with('success', 'Pedido realizado exitosamente. Revisa tu email para más detalles.');
        } else {
            return redirect()->route('carrito.comprobante', $pedido->id)->with('success', 'Pedido realizado exitosamente. Revisa tu email para más detalles.');
        }
    }

    public function comprobante($id)
    {
        $pedido = Pedido::with(['detalles.libro'])->findOrFail($id);
        
        // Verificar que el pedido pertenece al usuario actual o es de sesión
        $user = Auth::user();
        $session_id = session()->getId();
        
        if ($user && $pedido->user_id !== $user->id) {
            abort(403, 'No tienes permiso para ver este pedido');
        }
        
        if (!$user && $pedido->session_id !== $session_id) {
            abort(403, 'No tienes permiso para ver este pedido');
        }
        
        return view('carrito.comprobante', compact('pedido'));
    }
}
