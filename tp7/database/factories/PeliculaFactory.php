<?php

namespace Database\Factories;

use App\Models\Pelicula;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pelicula>
 */
class PeliculaFactory extends Factory
{
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('es_ES');

        $anioMaximo = now()->year + 5;

        $titulosEjemplo = [
            'El secreto de sus ojos',
            'Relatos salvajes',
            'Nueve reinas',
            'El ángel',
            'Medianeras',
            'Aballay',
            'Carancho',
            'La odisea de los giles',
            'El robo del siglo',
            'Metegol',
            'Luna de Avellaneda',
            'El hijo de la novia',
            'The Shawshank Redemption',
            'The Godfather',
            'The Dark Knight',
            'Pulp Fiction',
            'Inception',
            'Forrest Gump',
            'The Matrix',
            'Interstellar',
            'Gladiator',
            'Fight Club',
            'El señor de los anillos',
            'Goodfellas',
            'Se7en',
            'El silencio de los inocentes',
            'Rescatando al soldado Ryan',
        ];

        $generosEjemplo = ['Acción', 'Drama', 'Comedia', 'Terror', 'Ciencia Ficción', 'Suspenso'];

        return [
            'titulo' => $this->faker->unique()->randomElement($titulosEjemplo),
            'genero' => $this->faker->randomElement($generosEjemplo),
            'anio' => $this->faker->numberBetween(1980, $anioMaximo),
            'descripcion' => $this->faker->paragraph(3),
        ];
    }
}
