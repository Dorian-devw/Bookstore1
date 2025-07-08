<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Libro;
use App\Models\Categoria;
use App\Models\Autor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idiomas = ['español', 'inglés'];
        return [
            'titulo' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(),
            'precio' => $this->faker->randomFloat(2, 20, 150),
            'stock' => $this->faker->numberBetween(1, 50),
            'imagen' => 'https://placehold.co/200x300',
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? 1,
            'autor_id' => Autor::inRandomOrder()->first()?->id ?? 1,
            'idioma' => $this->faker->randomElement($idiomas),
            'valoracion' => $this->faker->randomFloat(1, 3, 5),
            'publicado_en' => $this->faker->date(),
        ];
    }
}
