<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Novela',
            'Fantasía',
            'Ciencia Ficción',
            'Misterio',
            'Romance',
            'Historia',
            'Biografía',
            'Autoayuda',
            'Infantil',
            'Juvenil',
            'Aventura',
            'Clásicos',
            'Terror',
            'Poesía',
            'Arte',
        ];
        foreach ($categorias as $cat) {
            Categoria::create([
                'nombre' => $cat,
                'descripcion' => 'Libros de ' . strtolower($cat),
            ]);
        }
    }
}
