<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Libro;
use App\Models\Pedido;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

// Controlador principal para la administración del sistema
class AdminController extends Controller
{
    // Muestra el panel principal de administración, con resumen de datos clave
    public function index()
    {
        // KPIs
        $ventasMes = Pedido::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->where('estado', 'completado')
            ->sum('total');
        $usuarios = User::count();
        $pedidosPendientes = Pedido::where('estado', 'pendiente')->count();
        $pedidosCompletados = Pedido::where('estado', 'completado')->count();
        $masVendidos = Libro::withCount(['detallesPedido as vendidos' => function($q) {
            $q->select(\DB::raw('SUM(cantidad)'));
        }])->orderByDesc('vendidos')->take(5)->get();
        $stockBajo = Libro::where('stock', '<', 5)->get();
        return view('admin.panel', compact('ventasMes', 'usuarios', 'pedidosPendientes', 'pedidosCompletados', 'masVendidos', 'stockBajo'));
    }

    public function generarReportePDF(Request $request)
    {
        $tipo = $request->input('tipo', 'ventas');
        $data = [];
        $titulo = '';
        switch ($tipo) {
            case 'ventas':
                $titulo = 'Reporte de Ventas';
                $data['pedidos'] = \App\Models\Pedido::with('user')->orderByDesc('fecha')->get();
                break;
            case 'stock':
                $titulo = 'Reporte de Stock';
                $data['libros'] = \App\Models\Libro::orderBy('stock')->get();
                break;
            case 'usuarios':
                $titulo = 'Reporte de Usuarios';
                $data['usuarios'] = \App\Models\User::orderBy('created_at', 'desc')->get();
                break;
            case 'pedidos':
                $titulo = 'Reporte de Pedidos';
                $data['pedidos'] = \App\Models\Pedido::with('user')->orderByDesc('fecha')->get();
                break;
            default:
                $titulo = 'Reporte';
        }
        $data['titulo'] = $titulo;
        $pdf = Pdf::loadView('admin.reportes.pdf', $data);
        return $pdf->download($titulo . '.pdf');
    }
}
