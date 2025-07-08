<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Autor;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Novela
        \App\Models\Autor::create(['nombre' => 'Gabriel García Márquez', 'nacionalidad' => 'Colombiana']);
        \App\Models\Autor::create(['nombre' => 'Isabel Allende', 'nacionalidad' => 'Chilena']);
        \App\Models\Autor::create(['nombre' => 'George Orwell', 'nacionalidad' => 'Británica']); // Inglés

        // Fantasía
        \App\Models\Autor::create(['nombre' => 'J.K. Rowling', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'J.R.R. Tolkien', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Patrick Rothfuss', 'nacionalidad' => 'Estadounidense']);

        // Ciencia Ficción
        \App\Models\Autor::create(['nombre' => 'Isaac Asimov', 'nacionalidad' => 'Rusa']);
        \App\Models\Autor::create(['nombre' => 'Philip K. Dick', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Arthur C. Clarke', 'nacionalidad' => 'Británica']); // Inglés

        // Misterio
        \App\Models\Autor::create(['nombre' => 'Agatha Christie', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Arthur Conan Doyle', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Patricia Highsmith', 'nacionalidad' => 'Estadounidense']);

        // Romance
        \App\Models\Autor::create(['nombre' => 'Jane Austen', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Nicholas Sparks', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Federico Moccia', 'nacionalidad' => 'Italiana']);

        // Historia
        \App\Models\Autor::create(['nombre' => 'Yuval Noah Harari', 'nacionalidad' => 'Israelí']);
        \App\Models\Autor::create(['nombre' => 'Mary Beard', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Simon Sebag Montefiore', 'nacionalidad' => 'Británica']); // Inglés

        // Biografía
        \App\Models\Autor::create(['nombre' => 'Walter Isaacson', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Michelle Obama', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Andrew Morton', 'nacionalidad' => 'Británica']); // Inglés

        // Autoayuda
        \App\Models\Autor::create(['nombre' => 'Stephen R. Covey', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Dale Carnegie', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Louise L. Hay', 'nacionalidad' => 'Estadounidense']);

        // Infantil
        \App\Models\Autor::create(['nombre' => 'Dr. Seuss', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Roald Dahl', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Astrid Lindgren', 'nacionalidad' => 'Sueca']);

        // Juvenil
        \App\Models\Autor::create(['nombre' => 'Suzanne Collins', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Rick Riordan', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'John Green', 'nacionalidad' => 'Estadounidense']);

        // Aventura
        \App\Models\Autor::create(['nombre' => 'Jules Verne', 'nacionalidad' => 'Francesa']);
        \App\Models\Autor::create(['nombre' => 'Robert Louis Stevenson', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Mark Twain', 'nacionalidad' => 'Estadounidense']);

        // Clásicos
        \App\Models\Autor::create(['nombre' => 'Miguel de Cervantes', 'nacionalidad' => 'Española']);
        \App\Models\Autor::create(['nombre' => 'William Shakespeare', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'Fiódor Dostoyevski', 'nacionalidad' => 'Rusa']);

        // Terror
        \App\Models\Autor::create(['nombre' => 'Stephen King', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'H.P. Lovecraft', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'Bram Stoker', 'nacionalidad' => 'Irlandesa']); // Inglés

        // Poesía
        \App\Models\Autor::create(['nombre' => 'Pablo Neruda', 'nacionalidad' => 'Chilena']);
        \App\Models\Autor::create(['nombre' => 'Emily Dickinson', 'nacionalidad' => 'Estadounidense']);
        \App\Models\Autor::create(['nombre' => 'William Wordsworth', 'nacionalidad' => 'Británica']); // Inglés

        // Arte
        \App\Models\Autor::create(['nombre' => 'Ernst Gombrich', 'nacionalidad' => 'Austríaca']);
        \App\Models\Autor::create(['nombre' => 'David Hockney', 'nacionalidad' => 'Británica']); // Inglés
        \App\Models\Autor::create(['nombre' => 'John Berger', 'nacionalidad' => 'Británica']); // Inglés
    }
}
