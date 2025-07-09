<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Libro;
use App\Models\Resena;

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRUEBA DEL SISTEMA DE VALORACIONES CON PROMEDIO PONDERADO ===\n\n";

// Buscar un libro con reseñas para probar
$libro = Libro::whereHas('resenasAprobadas')->first();

if (!$libro) {
    echo "No se encontró ningún libro con reseñas aprobadas.\n";
    echo "Creando una reseña de prueba...\n";
    
    $libro = Libro::first();
    $usuario = \App\Models\User::first();
    
    if ($libro && $usuario) {
        // Crear una reseña aprobada
        Resena::create([
            'user_id' => $usuario->id,
            'libro_id' => $libro->id,
            'calificacion' => 5,
            'comentario' => 'Reseña de prueba para el sistema de valoraciones',
            'estado' => 'aprobado'
        ]);
        
        echo "Reseña creada para el libro: {$libro->titulo}\n";
    }
}

if ($libro) {
    echo "Libro: {$libro->titulo}\n";
    echo "Valoración por defecto: {$libro->valoracion_por_defecto}\n";
    echo "Reseñas aprobadas: " . $libro->resenasAprobadas()->count() . "\n";
    
    if ($libro->resenasAprobadas()->count() > 0) {
        $promedioResenas = $libro->resenasAprobadas()->avg('calificacion');
        echo "Promedio de reseñas de usuarios: {$promedioResenas}\n";
        
        // Calcular manualmente el promedio ponderado
        $valoracionFinal = ($promedioResenas * 0.7) + ($libro->valoracion_por_defecto * 0.3);
        echo "Promedio ponderado calculado: " . round($valoracionFinal, 1) . "\n";
        
        // Usar el método del modelo
        $valoracionModelo = $libro->valoracion_promedio;
        echo "Valoración del modelo: {$valoracionModelo}\n";
        
        echo "\nDetalle de reseñas:\n";
        foreach ($libro->resenasAprobadas as $resena) {
            echo "  - Usuario: {$resena->user->name}, Calificación: {$resena->calificacion}/5\n";
        }
    }
    
    echo "\nValoración actual en BD: {$libro->valoracion}\n";
}

echo "\n=== FIN DE LA PRUEBA ===\n"; 