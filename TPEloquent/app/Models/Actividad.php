<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = ['titulo', 'descripcion', 'fecha', 'hora', 'cupo', 'precio', 'imagen', 'estado'];

    protected function casts(): array
    {
        return ['fecha' => 'date', 'precio' => 'decimal:2'];
    }


    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk('public')->url($ruta);
    }
}
