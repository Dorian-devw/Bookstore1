<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Autor;

echo "Autores disponibles:\n";
foreach(Autor::all() as $autor) {
    echo "- " . $autor->nombre . "\n";
} 