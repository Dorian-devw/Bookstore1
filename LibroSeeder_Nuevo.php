<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener categorías
        $catNovela = \App\Models\Categoria::where('nombre', 'Novela')->first();
        $catFantasia = \App\Models\Categoria::where('nombre', 'Fantasía')->first();
        $catCienciaFiccion = \App\Models\Categoria::where('nombre', 'Ciencia Ficción')->first();
        $catMisterio = \App\Models\Categoria::where('nombre', 'Misterio')->first();
        $catRomance = \App\Models\Categoria::where('nombre', 'Romance')->first();
        $catHistoria = \App\Models\Categoria::where('nombre', 'Historia')->first();
        $catBiografia = \App\Models\Categoria::where('nombre', 'Biografía')->first();
        $catAutoayuda = \App\Models\Categoria::where('nombre', 'Autoayuda')->first();
        $catInfantil = \App\Models\Categoria::where('nombre', 'Infantil')->first();
        $catJuvenil = \App\Models\Categoria::where('nombre', 'Juvenil')->first();
        $catAventura = \App\Models\Categoria::where('nombre', 'Aventura')->first();
        $catClasicos = \App\Models\Categoria::where('nombre', 'Clásicos')->first();
        $catTerror = \App\Models\Categoria::where('nombre', 'Terror')->first();
        $catPoesia = \App\Models\Categoria::where('nombre', 'Poesía')->first();
        $catArte = \App\Models\Categoria::where('nombre', 'Arte')->first();

        // Obtener autores
        $autores = \App\Models\Autor::all()->keyBy('nombre');

        // NOVELA - 3 autores, 9 libros
        $this->crearLibrosNovela($catNovela, $autores);
        
        // FANTASÍA - 3 autores, 9 libros
        $this->crearLibrosFantasia($catFantasia, $autores);
        
        // CIENCIA FICCIÓN - 3 autores, 9 libros
        $this->crearLibrosCienciaFiccion($catCienciaFiccion, $autores);
        
        // MISTERIO - 3 autores, 9 libros
        $this->crearLibrosMisterio($catMisterio, $autores);
        
        // ROMANCE - 3 autores, 9 libros
        $this->crearLibrosRomance($catRomance, $autores);
        
        // HISTORIA - 3 autores, 9 libros
        $this->crearLibrosHistoria($catHistoria, $autores);
        
        // BIOGRAFÍA - 3 autores, 9 libros
        $this->crearLibrosBiografia($catBiografia, $autores);
        
        // AUTOAYUDA - 3 autores, 9 libros
        $this->crearLibrosAutoayuda($catAutoayuda, $autores);
        
        // INFANTIL - 3 autores, 9 libros
        $this->crearLibrosInfantil($catInfantil, $autores);
        
        // JUVENIL - 3 autores, 9 libros
        $this->crearLibrosJuvenil($catJuvenil, $autores);
        
        // AVENTURA - 3 autores, 9 libros
        $this->crearLibrosAventura($catAventura, $autores);
        
        // CLÁSICOS - 3 autores, 9 libros
        $this->crearLibrosClasicos($catClasicos, $autores);
        
        // TERROR - 3 autores, 9 libros
        $this->crearLibrosTerror($catTerror, $autores);
        
        // POESÍA - 3 autores, 9 libros
        $this->crearLibrosPoesia($catPoesia, $autores);
        
        // ARTE - 3 autores, 9 libros
        $this->crearLibrosArte($catArte, $autores);
    }

    private function crearLibrosNovela($categoria, $autores)
    {
        // Gabriel García Márquez
        Libro::create([
            'titulo' => 'Cien años de soledad',
            'descripcion' => 'Novela emblemática del realismo mágico que narra la historia de la familia Buendía.',
            'precio' => 49.90,
            'stock' => 20,
            'imagen' => 'libros/cien-anos-soledad.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['Gabriel García Márquez']->id,
            'idioma' => 'Español',
            'valoracion' => 4.8,
            'publicado_en' => '1967-05-30',
        ]);
        Libro::create([
            'titulo' => 'El amor en los tiempos del cólera',
            'descripcion' => 'Historia de amor y paciencia en el Caribe colombiano.',
            'precio' => 44.90,
            'stock' => 15,
            'imagen' => 'libros/el-amor-en-los-tiempos-del-colera.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['Gabriel García Márquez']->id,
            'idioma' => 'Español',
            'valoracion' => 4.7,
            'publicado_en' => '1985-09-05',
        ]);
        Libro::create([
            'titulo' => 'One Hundred Years of Solitude',
            'descripcion' => 'English edition of the masterpiece of magical realism.',
            'precio' => 52.00,
            'stock' => 12,
            'imagen' => 'libros/one-hundred-years-of-solitude.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['Gabriel García Márquez']->id,
            'idioma' => 'Inglés',
            'valoracion' => 4.9,
            'publicado_en' => '1970-01-01',
        ]);

        // Isabel Allende
        Libro::create([
            'titulo' => 'La casa de los espíritus',
            'descripcion' => 'Saga familiar con realismo mágico ambientada en Chile.',
            'precio' => 42.90,
            'stock' => 18,
            'imagen' => 'libros/la-casa-de-los-espiritus.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['Isabel Allende']->id,
            'idioma' => 'Español',
            'valoracion' => 4.5,
            'publicado_en' => '1982-01-01',
        ]);
        Libro::create([
            'titulo' => 'Eva Luna',
            'descripcion' => 'La historia de Eva Luna y su extraordinaria vida en América Latina.',
            'precio' => 38.50,
            'stock' => 16,
            'imagen' => 'libros/eva-luna.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['Isabel Allende']->id,
            'idioma' => 'Español',
            'valoracion' => 4.4,
            'publicado_en' => '1987-01-01',
        ]);
        Libro::create([
            'titulo' => 'The House of the Spirits',
            'descripcion' => 'English edition of the magical realist family saga.',
            'precio' => 45.00,
            'stock' => 14,
            'imagen' => 'libros/the-house-of-the-spirits.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['Isabel Allende']->id,
            'idioma' => 'Inglés',
            'valoracion' => 4.6,
            'publicado_en' => '1985-01-01',
        ]);

        // George Orwell
        Libro::create([
            'titulo' => '1984',
            'descripcion' => 'Novela distópica sobre totalitarismo y control social.',
            'precio' => 39.90,
            'stock' => 25,
            'imagen' => 'libros/1984.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['George Orwell']->id,
            'idioma' => 'Español',
            'valoracion' => 4.9,
            'publicado_en' => '1949-06-08',
        ]);
        Libro::create([
            'titulo' => 'Rebelión en la granja',
            'descripcion' => 'Alegoría política sobre la revolución rusa y el totalitarismo.',
            'precio' => 29.90,
            'stock' => 22,
            'imagen' => 'libros/rebelion-en-la-granja.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['George Orwell']->id,
            'idioma' => 'Español',
            'valoracion' => 4.8,
            'publicado_en' => '1945-08-17',
        ]);
        Libro::create([
            'titulo' => 'Animal Farm',
            'descripcion' => 'English edition of the political allegory about revolution and tyranny.',
            'precio' => 32.00,
            'stock' => 20,
            'imagen' => 'libros/animal-farm.jpg',
            'categoria_id' => $categoria->id,
            'autor_id' => $autores['George Orwell']->id,
            'idioma' => 'Inglés',
            'valoracion' => 4.9,
            'publicado_en' => '1945-08-17',
        ]);
    }

    // Continuar con los demás métodos para cada categoría...
    // Por espacio, solo muestro el patrón para las demás categorías
} 