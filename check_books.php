<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Categoria;
use App\Models\Libro;

echo "Total libros: " . Libro::count() . "\n\n";

echo "Libros por categoría:\n";
foreach(Categoria::withCount('libros')->get() as $cat) {
    echo $cat->nombre . ': ' . $cat->libros_count . "\n";
}

echo "\nPrimeros 10 libros:\n";
foreach(Libro::take(10)->get() as $libro) {
    echo "- " . $libro->titulo . " (" . $libro->categoria->nombre . ")\n";
} 