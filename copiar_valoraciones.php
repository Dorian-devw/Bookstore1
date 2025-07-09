<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Copiando valoraciones al campo valoracion_por_defecto...\n";

// Actualizar todos los libros
$resultado = DB::table('libros')
    ->where('valoracion_por_defecto', 0)
    ->update([
        'valoracion_por_defecto' => DB::raw('valoracion')
    ]);

echo "Libros actualizados: {$resultado}\n";

// Verificar algunos libros
$libros = DB::table('libros')->take(3)->get();
foreach ($libros as $libro) {
    echo "Libro: {$libro->titulo}\n";
    echo "  - valoracion: {$libro->valoracion}\n";
    echo "  - valoracion_por_defecto: {$libro->valoracion_por_defecto}\n\n";
}

echo "Proceso completado.\n"; 