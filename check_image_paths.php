<?php

require_once 'vendor/autoload.php';

use App\Models\Libro;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VERIFICACIÓN DE RUTAS DE IMÁGENES ===\n\n";

// Obtener algunos libros
$libros = Libro::with(['autor', 'categoria'])->take(5)->get();

foreach ($libros as $libro) {
    echo "Libro: {$libro->titulo}\n";
    echo "Imagen en BD: {$libro->imagen}\n";
    
    // Verificar si la imagen existe en public/libros/
    $rutaCompleta = public_path($libro->imagen);
    $existe = file_exists($rutaCompleta);
    
    echo "Ruta completa: {$rutaCompleta}\n";
    echo "¿Existe?: " . ($existe ? 'SÍ' : 'NO') . "\n";
    
    // Generar URL con asset()
    $url = asset($libro->imagen);
    echo "URL generada: {$url}\n";
    
    echo "---\n";
}

echo "\n=== VERIFICACIÓN COMPLETA ===\n"; 