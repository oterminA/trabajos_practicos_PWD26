<?php
//relacion 1:N con reseniaspelicula, una peli tiene muchas reseñas y una reseña pertenece a una peli
//relacion N:M con actores, una peli tiene muchos actores y muchos actores pertenecen a varias peliculas
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Pelicula extends Model
{
    public function resenias()
    {
        return $this->hasMany(Resenia::class, 'pelicula_id'); //esto va en el lado 1 de la relación 1:n
    }

    public function actores()
    {
        return $this->belongsToMany(Actor::class, 'actor_pelicula'); //esto va en el lado n de la relación
    }

    protected $guarded = [
        'id'
    ];

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
        ];
    }

    /**
     *atributo inteligente para mostrar el titulo de la pelicula formateado onda "Matrix (año)"
     */
    protected function tituloFormateado(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->titulo} ({$this->anio})"
        );
    }


    /**
     *atributo inteligente para mostrar el promedio de puntaje
     */
    protected function promedioPuntaje(): Attribute
    {
        return Attribute::make(
            get: fn() => round($this->attributes['resenias_avg_puntaje'] ?? $this->resenias()->avg('puntaje') ?? 0, 1)
        );
    }


    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk('public')->url($ruta);
    }
}
