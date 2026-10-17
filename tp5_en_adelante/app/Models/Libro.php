<?php
//relacion 1:N con reseniaslibro, un libro tiene muchas reseñas y una reseña pertenece a un libro
//lado 1 de 1:n
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Libro extends Model
{
    public function resenias()
    {
        return $this->hasMany(ReseniaLibro::class);; //esto va en el lado 1 de la relación 1:n
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

    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk('public')->url($ruta);
    }
}
