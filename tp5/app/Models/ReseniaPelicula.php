<?php
//relacion 1:n con pelicula, una reseña pertenece a una pelicula y una pelicula tiene michas reseñas
//lado n de 1:n
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReseniaPelicula extends Model
{

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class, 'pelicula_id'); //esto es lo que necesito para conectar las tablas del lado del MODELO
    }

    protected $guarded = [
        'id'
    ];

    protected function casts(): array
    {
        return [
            'puntaje' => 'integer',
        ];
    }
}
