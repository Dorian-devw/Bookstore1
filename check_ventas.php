<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pedido;
use Carbon\Carbon;

echo "=== VERIFICACIÓN DE VENTAS DEL MES ===\n";
echo "Mes actual: " . Carbon::now()->format('F Y') . "\n\n";

// Total de pedidos del mes
$totalPedidos = Pedido::whereMonth('fecha', now()->month)
    ->whereYear('fecha', now()->year)
    ->count();
echo "Total pedidos del mes: " . $totalPedidos . "\n";

// Pedidos con pago completado
$pedidosPagados = Pedido::whereMonth('fecha', now()->month)
    ->whereYear('fecha', now()->year)
    ->whereHas('pago', function($q) {
        $q->where('estado', 'completado');
    })
    ->count();
echo "Pedidos con pago completado: " . $pedidosPagados . "\n";

// Total ventas del mes (solo pagados)
$ventasMes = Pedido::whereMonth('fecha', now()->month)
    ->whereYear('fecha', now()->year)
    ->whereHas('pago', function($q) {
        $q->where('estado', 'completado');
    })
    ->sum('total');
echo "Total ventas del mes: S/ " . number_format($ventasMes, 2) . "\n\n";

// Mostrar algunos pedidos del mes para debug
echo "=== PEDIDOS DEL MES ===\n";
$pedidos = Pedido::whereMonth('fecha', now()->month)
    ->whereYear('fecha', now()->year)
    ->with('pago')
    ->take(5)
    ->get();

foreach ($pedidos as $pedido) {
    echo "Pedido #{$pedido->id} - Fecha: {$pedido->fecha} - Total: S/ {$pedido->total} - Estado: {$pedido->estado} - Pago: " . ($pedido->pago ? $pedido->pago->estado : 'Sin pago') . "\n";
}

echo "\n=== TODOS LOS PEDIDOS (últimos 10) ===\n";
$todosPedidos = Pedido::with('pago')->orderBy('fecha', 'desc')->take(10)->get();

foreach ($todosPedidos as $pedido) {
    echo "Pedido #{$pedido->id} - Fecha: {$pedido->fecha} - Total: S/ {$pedido->total} - Estado: {$pedido->estado} - Pago: " . ($pedido->pago ? $pedido->pago->estado : 'Sin pago') . "\n";
} 