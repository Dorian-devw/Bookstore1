<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;
use App\Models\Libro;
use App\Models\Pago;
use Carbon\Carbon;

echo "=== CREANDO PEDIDOS PARA JULIO 2025 ===\n";

$usuarios = User::where('email', '!=', 'admin@flying-bookstore.com')->get();
$libros = Libro::all();

if ($usuarios->isEmpty() || $libros->isEmpty()) {
    echo "No hay usuarios o libros disponibles.\n";
    exit;
}

// Crear 8 pedidos para julio 2025
for ($i = 0; $i < 8; $i++) {
    $usuario = $usuarios->random();
    $fecha = Carbon::now()->subDays(rand(1, 6)); // Últimos 6 días de julio
    
    $metodoPago = ['tarjeta', 'yape', 'transferencia'][array_rand(['tarjeta', 'yape', 'transferencia'])];
    
    // Crear pedido
    $pedido = Pedido::create([
        'user_id' => $usuario->id,
        'fecha' => $fecha,
        'total' => 0,
        'metodo_pago' => $metodoPago,
    ]);

    // Crear detalles del pedido (1-3 libros por pedido)
    $totalPedido = 0;
    $cantidadLibros = rand(1, 3);
    $librosPedido = $libros->random($cantidadLibros);
    
    foreach ($librosPedido as $libro) {
        $cantidad = rand(1, 2);
        $precio = $libro->precio;
        $subtotal = $precio * $cantidad;
        $totalPedido += $subtotal;

        DetallePedido::create([
            'pedido_id' => $pedido->id,
            'libro_id' => $libro->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
        ]);
    }

    // Actualizar total del pedido
    $pedido->update(['total' => $totalPedido]);

    // Crear pago completado
    Pago::create([
        'pedido_id' => $pedido->id,
        'tipo' => $metodoPago,
        'estado' => 'completado',
        'fecha' => $fecha,
    ]);

    echo "Pedido #{$pedido->id} creado - Total: S/ {$totalPedido} - Fecha: {$fecha->format('d/m/Y')}\n";
}

echo "\n¡Pedidos de julio creados exitosamente!\n";
echo "Ahora puedes verificar las ventas del mes en el panel de administrador.\n"; 