<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use App\Models\DetallePedido;
use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPedidoController extends Controller
{
    // Listado de pedidos con filtros y búsqueda
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

    // Detalle de pedido
    public function show($id)
    {
        $pedido = Pedido::with(['user', 'detalles.libro', 'pago'])->findOrFail($id);
        return view('admin.pedidos.show', compact('pedido'));
    }

    // Actualizar estado del pedido
    public function actualizarEstado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $request->validate([
            'estado' => 'required|in:pendiente,completado,cancelado,enviado',
        ]);
        $pedido->estado = $request->estado;
        $pedido->save();
        return redirect()->route('admin.pedidos.show', $pedido->id)->with('success', 'Estado actualizado correctamente');
    }

    public function comprobante($id)
    {
        $pedido = Pedido::with(['user', 'detalles.libro', 'pago'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.pedidos.comprobante', compact('pedido'));
        return $pdf->download('comprobante_pedido_'.$pedido->id.'.pdf');
    }
}
