<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pregunta;


class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pregunta::create([
            'keyword' => 'mis reseñas',
            'response' => 'Por el momento el usuario logueado no puede ver sus reseñas. Esa funcionalidad queda pendiente de implementarse.'
        ]);

        Pregunta::create([
            'keyword' => 'ver reseña',
            'response' => 'Para ver las reseñas de una película se debe apretar el botón de "ver reseñas" dentro de la película ("ver detalle" en la película elegida).'
        ]);

         Pregunta::create([
            'keyword' => 'subir',
            'response' => 'Los usuarios no pueden subir películas, solo pueden buscar/ver/reseñar las existentes.'
        ]);


        Pregunta::create([
            'keyword' => 'reseña',
            'response' => 'Para añadir una reseña se debe contar con una cuenta de usuario.'
        ]);

        Pregunta::create([
            'keyword' => 'cuenta',
            'response' => 'Para crear una cuenta de usuario se debe tocar el botón "iniciar sesión" > "crear cuenta".'
        ]);

        Pregunta::create([
            'keyword' => 'pelicula',
            'response' => 'Para ver las películas se puede hacer un filtrado por "género", por "películas sin imagen", buscando por título o simplemente explorando el catálogo disponible.'
        ]);
    }
}
