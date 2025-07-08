<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Resena;
use App\Models\User;
use App\Models\Libro;
use Carbon\Carbon;

class ResenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::where('email', '!=', 'admin@flying-bookstore.com')->get();
        $libros = Libro::all();
        
        if ($usuarios->isEmpty() || $libros->isEmpty()) {
            $this->command->error('No hay usuarios o libros disponibles para crear reseñas.');
            return;
        }

        $comentarios = [
            'Excelente libro, muy recomendado para todos los lectores.',
            'Una historia fascinante que te mantiene enganchado hasta el final.',
            'Buen libro, aunque esperaba algo más de la trama.',
            'Muy bien escrito, los personajes están muy desarrollados.',
            'No me gustó mucho, la historia es muy lenta.',
            'Increíble, uno de los mejores libros que he leído este año.',
            'Interesante perspectiva, vale la pena leerlo.',
            'Bueno para pasar el tiempo, pero nada extraordinario.',
            'Altamente recomendado, especialmente para los amantes del género.',
            'Una decepción, no cumple con las expectativas.',
            'Muy entretenido, perfecto para una tarde de lectura.',
            'El autor tiene un estilo único y cautivador.',
            'Buena historia, aunque el final es predecible.',
            'Fascinante desde la primera página hasta la última.',
            'Un clásico moderno que no te puedes perder.',
            'Bien estructurado, pero falta más acción.',
            'Excelente desarrollo de personajes y trama.',
            'Muy original, una historia que te sorprende.',
            'Buen libro para principiantes en el género.',
            'Una obra maestra que supera todas las expectativas.',
        ];

        $estados = ['pendiente', 'aprobado', 'rechazado'];

        // Crear reseñas para diferentes libros
        for ($i = 0; $i < 35; $i++) {
            $usuario = $usuarios->random();
            $libro = $libros->random();
            $fecha = Carbon::now()->subDays(rand(1, 60));
            $estado = $estados[array_rand($estados)];
            
            // Verificar que no exista ya una reseña de este usuario para este libro
            $existeResena = Resena::where('user_id', $usuario->id)
                                 ->where('libro_id', $libro->id)
                                 ->exists();
            
            if (!$existeResena) {
                Resena::create([
                    'user_id' => $usuario->id,
                    'libro_id' => $libro->id,
                    'calificacion' => rand(1, 5),
                    'comentario' => $comentarios[array_rand($comentarios)],
                    'estado' => $estado,
                    'created_at' => $fecha,
                ]);
            }
        }

        $this->command->info('Reseñas de prueba creadas exitosamente.');
    }
}
