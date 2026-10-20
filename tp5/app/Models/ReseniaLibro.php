<?php
//relacion 1:n con libro, una reseña pertenece a un libro y un libro tiene michas reseñas
//lado n de 1:n
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReseniaLibro extends Model
{
    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id'); //para conectar las tablas mediante el MODELO
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
