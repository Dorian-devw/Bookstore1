<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Libro;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Actualizando valoraciones por defecto...\n";

// Copiar valoraciones actuales al campo valoracion_por_defecto
$libros = Libro::all();
$actualizados = 0;

foreach ($libros as $libro) {
    if ($libro->valoracion_por_defecto == 0) {
        $libro->update([
            'valoracion_por_defecto' => $libro->valoracion
        ]);
        $actualizados++;
        echo "Libro '{$libro->titulo}': valoración por defecto establecida en {$libro->valoracion}\n";
    }
}

echo "\nTotal de libros actualizados: {$actualizados}\n";
echo "Proceso completado.\n"; 