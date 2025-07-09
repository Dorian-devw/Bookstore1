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

// Controlador para la gestión del carrito de compras
class CarritoController extends Controller
{
    // Muestra el contenido del carrito y aplica cupones si existen
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

    // Agrega un libro al carrito, validando stock y sesión/usuario
    public function agregar(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'redirect' => route('carrito.advertencia_login'),
                    'message' => 'Debes iniciar sesión o registrarte para agregar productos al carrito.'
                ]);
            }
            return view('carrito.advertencia_login');
        }
        $request->validate([
            'libro_id' => 'required|exists:libros,id',
            'cantidad' => 'required|integer|min:1',
        ]);
        
        $session_id = session()->getId();
        $libro = Libro::findOrFail($request->libro_id);
        
        // Verificar stock disponible (excluyendo reservas activas de otros usuarios)
        $stockReservado = Carrito::where('libro_id', $request->libro_id)
            ->where('reservado_hasta', '>', now())
            ->when($user, fn($q) => $q->where('user_id', '!=', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', '!=', $session_id))
            ->sum('cantidad');
        
        $stockDisponible = $libro->stock - $stockReservado;
        
        if ($stockDisponible < $request->cantidad) {
            $mensaje = "Solo hay {$stockDisponible} unidades disponibles de este libro.";
            if ($stockReservado > 0) {
                $mensaje .= " Otros clientes están comprando {$stockReservado} unidades en este momento.";
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $mensaje
                ]);
            }
            return redirect()->back()->with('error', $mensaje);
        }
        
        // Verificar si ya está en el carrito
        $carrito = Carrito::where('libro_id', $request->libro_id)
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->first();
            
        if ($carrito) {
            // Verificar que no exceda el stock disponible al agregar más
            if (($carrito->cantidad + $request->cantidad) > $stockDisponible) {
                $mensaje = "No hay suficientes unidades disponibles. Máximo: {$stockDisponible}";
                if ($stockReservado > 0) {
                    $mensaje .= " (otros clientes están comprando {$stockReservado} unidades)";
                }
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $mensaje
                    ]);
                }
                return redirect()->back()->with('error', $mensaje);
            }
            $carrito->cantidad += $request->cantidad;
            $carrito->reservado_hasta = now()->addMinutes(30);
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
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => '¡Libro añadido al carrito exitosamente!'
            ]);
        }
        // Redirección especial desde el carrusel
        if ($request->has('redirect_to_carrito')) {
            return redirect()->route('carrito.index');
        }
        return redirect()->back()->with('success', '¡Libro añadido al carrito exitosamente!');
    }

    // Elimina un libro del carrito
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

    // Actualiza la cantidad de un libro en el carrito
    public function actualizarCantidad(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);
        
        $user = Auth::user();
        $session_id = session()->getId();
        $carrito = Carrito::with('libro')
            ->where('id', $id)
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->firstOrFail();
        
        $libro = $carrito->libro;
        
        // Verificar stock disponible
        $stockReservado = Carrito::where('libro_id', $libro->id)
            ->where('reservado_hasta', '>', now())
            ->when($user, fn($q) => $q->where('user_id', '!=', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', '!=', $session_id))
            ->sum('cantidad');
        
        $stockDisponible = $libro->stock - $stockReservado;
        
        if ($request->cantidad > $stockDisponible) {
            return response()->json([
                'success' => false,
                'message' => "Solo hay {$stockDisponible} unidades disponibles"
            ]);
        }
        
        $carrito->cantidad = $request->cantidad;
        $carrito->reservado_hasta = now()->addMinutes(30);
        $carrito->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada'
        ]);
    }

    // Confirma la compra y muestra el resumen antes de procesar
    public function confirmar()
    {
        $user = Auth::user();
        if (!$user) {
            return view('carrito.advertencia_login');
        }
        $session_id = session()->getId();
        $carrito = Carrito::with('libro')
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('session_id', $session_id))
            ->get();
            
        // Verificar que todos los items del carrito siguen teniendo stock disponible
        foreach ($carrito as $item) {
            $stockReservado = Carrito::where('libro_id', $item->libro_id)
                ->where('reservado_hasta', '>', now())
                ->when($user, fn($q) => $q->where('user_id', '!=', $user->id))
                ->when(!$user, fn($q) => $q->where('session_id', '!=', $session_id))
                ->sum('cantidad');
            
            $stockDisponible = $item->libro->stock - $stockReservado;
            
            if ($stockDisponible < $item->cantidad) {
                // Eliminar item del carrito si no hay stock suficiente
                $item->delete();
                $mensaje = "El libro '{$item->libro->titulo}' ya no tiene stock suficiente. Se ha eliminado del carrito.";
                if ($stockReservado > 0) {
                    $mensaje .= " Otros clientes están comprando {$stockReservado} unidades en este momento.";
                }
                return redirect()->route('carrito.index')->with('error', $mensaje);
            }
        }
        
        $direcciones = $user ? Direccion::where('user_id', $user->id)->get() : collect();
        $total = $carrito->sum(fn($item) => $item->libro->precio * $item->cantidad);
        $descuento = session('descuento') ?? 0;
        $cupon = session('cupon_codigo') ?? null;
        return view('confirmar_compra', compact('carrito', 'total', 'direcciones', 'descuento', 'cupon'));
    }

    // Procesa la compra, crea el pedido y el pago, y envía el correo de confirmación
    public function procesarCompra(Request $request)
    {
        // Debug: Log de los datos recibidos
        \Log::info('Datos del formulario recibidos:', [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion_completa' => $request->direccion_completa,
            'fecha_entrega' => $request->fecha_entrega,
            'metodo_pago' => $request->metodo_pago,
        ]);

        $request->validate([
            'metodo_pago' => 'required|in:tarjeta,yape,transferencia',
            'direccion_id' => 'nullable|exists:direcciones,id',
            'cupon_codigo' => 'nullable|string',
            // Campos requeridos para todos los usuarios
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'direccion_completa' => 'required|string|max:500',
            'fecha_entrega' => 'required|date|after:today',
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
            // Datos del formulario para todos los usuarios
            'cliente_nombre' => $request->nombre,
            'cliente_email' => $request->email,
            'cliente_telefono' => $request->telefono,
            'direccion_entrega' => $request->direccion_completa,
            'fecha_entrega' => $request->fecha_entrega,
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

    // Muestra el comprobante de compra al usuario
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
