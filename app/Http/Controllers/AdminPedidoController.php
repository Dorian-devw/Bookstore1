<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use App\Models\DetallePedido;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;

// Controlador para la gestión de pedidos en el panel de administración
class AdminPedidoController extends Controller
{
    // Muestra la lista de pedidos para administración, con filtros y búsqueda
    public function index(Request $request)
    {
        $query = Pedido::with('user', 'pago');
        
        // Filtro por estado del pedido
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        // Filtro por método de pago
        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }
        
        // Filtro por rango de fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }
        
        // Filtro por monto mínimo
        if ($request->filled('monto_min')) {
            $query->where('total', '>=', $request->monto_min);
        }
        
        // Filtro por monto máximo
        if ($request->filled('monto_max')) {
            $query->where('total', '<=', $request->monto_max);
        }
        
        // Filtro por estado de pago
        if ($request->filled('estado_pago')) {
            $query->whereHas('pago', function($q) use ($request) {
                $q->where('estado', $request->estado_pago);
            });
        }
        
        // Búsqueda por usuario
        if ($request->filled('buscar')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->buscar . '%')
                  ->orWhere('email', 'like', '%' . $request->buscar . '%');
            });
        }
        
        $pedidos = $query->orderByDesc('fecha')->paginate(12);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    // Muestra el detalle de un pedido específico, incluyendo usuario, libros y estado
    public function show($id)
    {
        $pedido = Pedido::with(['user', 'detalles.libro', 'pago'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    // Permite actualizar el estado de un pedido (por ejemplo: pendiente, enviado, entregado)
    public function actualizarEstado(Request $request, $id)
    {
        $pedido = Pedido::with('detalles.libro')->findOrFail($id);
        $request->validate([
            'estado' => 'required|in:pendiente,completado,cancelado,enviado',
        ]);
        
        $estadoAnterior = $pedido->estado;
        $nuevoEstado = $request->estado;
        
        // Si se cancela un pedido que no estaba cancelado, restaurar stock
        if ($nuevoEstado === 'cancelado' && $estadoAnterior !== 'cancelado') {
            \Log::info("Restaurando stock para pedido #{$pedido->id}");
            foreach ($pedido->detalles as $detalle) {
                $stockAnterior = $detalle->libro->stock;
                $detalle->libro->increment('stock', $detalle->cantidad);
                $stockNuevo = $detalle->libro->fresh()->stock;
                \Log::info("Libro {$detalle->libro->titulo}: stock {$stockAnterior} + {$detalle->cantidad} = {$stockNuevo}");
            }
        }
        
        // Si se des-cancela un pedido (cambia de cancelado a otro estado), reducir stock nuevamente
        if ($estadoAnterior === 'cancelado' && $nuevoEstado !== 'cancelado') {
            foreach ($pedido->detalles as $detalle) {
                $detalle->libro->decrement('stock', $detalle->cantidad);
            }
        }
        
        $pedido->estado = $nuevoEstado;
        $pedido->save();
        
        return redirect()->route('admin.pedidos.show', $pedido->id)->with('success', 'Estado actualizado correctamente');
    }

    // Permite descargar el comprobante PDF del pedido para control administrativo
    public function comprobante($id)
    {
        $pedido = Pedido::with(['user', 'detalles.libro', 'pago'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.pedidos.comprobante', compact('pedido'));
        return $pdf->download('comprobante_pedido_'.$pedido->id.'.pdf');
    }
}
