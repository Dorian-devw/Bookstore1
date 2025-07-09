<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Carrito;
use App\Models\Libro;
use App\Models\User;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRUEBA DEL SISTEMA DE CANTIDADES DEL CARRITO ===\n\n";

// Verificar algunos carritos existentes
$carritos = Carrito::with('libro')->take(5)->get();

if ($carritos->isEmpty()) {
    echo "No hay items en el carrito para probar.\n";
    echo "Para probar el sistema:\n";
    echo "1. Agrega libros al carrito desde el catálogo\n";
    echo "2. Modifica las cantidades en el carrito\n";
    echo "3. Verifica que se mantengan al continuar\n";
} else {
    echo "Items en el carrito:\n";
    foreach ($carritos as $item) {
        echo "- Libro: {$item->libro->titulo}\n";
        echo "  Cantidad: {$item->cantidad}\n";
        echo "  Precio unitario: S/ {$item->libro->precio}\n";
        echo "  Precio total: S/ " . number_format($item->libro->precio * $item->cantidad, 2) . "\n";
        echo "  Reservado hasta: {$item->reservado_hasta}\n\n";
    }
}

// Verificar stock de algunos libros
echo "Stock de algunos libros:\n";
$libros = Libro::take(3)->get();
foreach ($libros as $libro) {
    $stockReservado = Carrito::where('libro_id', $libro->id)
        ->where('reservado_hasta', '>', now())
        ->sum('cantidad');
    
    echo "- {$libro->titulo}\n";
    echo "  Stock total: {$libro->stock}\n";
    echo "  Stock reservado: {$stockReservado}\n";
    echo "  Stock disponible: " . ($libro->stock - $stockReservado) . "\n\n";
}

echo "=== FIN DE LA PRUEBA ===\n"; 