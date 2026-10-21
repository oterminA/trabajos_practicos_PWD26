<?php
//relacion N:M con pelicula, una peli tiene muchos actores y muchos actores pertenecen a varias peliculas
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Actor extends Model
{
    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class, 'pelicula_id');
    }

    protected $guarded = [
        'id'
    ];



    /**
     *atributo inteligente para mostrar el titulo de la pelicula formateado onda "Reeves, Keanu"
     */
    protected function nombreFormateado(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->apellido}, {$this->nombre}"
        );
    }
}
