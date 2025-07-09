<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Libro;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Verificando valoraciones...\n";

// Verificar algunos libros
$libros = Libro::take(5)->get();

foreach ($libros as $libro) {
    echo "Libro: {$libro->titulo}\n";
    echo "  - valoracion: {$libro->valoracion}\n";
    echo "  - valoracion_por_defecto: {$libro->valoracion_por_defecto}\n";
    echo "  - resenas aprobadas: " . $libro->resenasAprobadas()->count() . "\n";
    if ($libro->resenasAprobadas()->count() > 0) {
        echo "  - promedio resenas: " . $libro->resenasAprobadas()->avg('calificacion') . "\n";
    }
    echo "\n";
}

echo "Proceso completado.\n"; 