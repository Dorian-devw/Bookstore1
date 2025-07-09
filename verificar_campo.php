<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Verificando estructura de la tabla libros...\n";

// Verificar si el campo existe
$columnas = Schema::getColumnListing('libros');
echo "Columnas en la tabla libros:\n";
foreach ($columnas as $columna) {
    echo "  - {$columna}\n";
}

echo "\nVerificando datos de un libro...\n";
$libro = DB::table('libros')->first();
if ($libro) {
    echo "Datos del primer libro:\n";
    foreach ($libro as $campo => $valor) {
        echo "  - {$campo}: {$valor}\n";
    }
}

echo "\nProceso completado.\n"; 