<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Libro;

$libro = Libro::where('titulo', 'Cien años de soledad')->first();

if ($libro) {
    echo "Libro: " . $libro->titulo . "\n";
    echo "Imagen en BD: " . $libro->imagen . "\n";
    echo "Ruta completa: " . asset('storage/' . $libro->imagen) . "\n";
    echo "¿Existe archivo?: " . (file_exists(storage_path('app/public/' . $libro->imagen)) ? 'SÍ' : 'NO') . "\n";
} else {
    echo "Libro no encontrado\n";
} 