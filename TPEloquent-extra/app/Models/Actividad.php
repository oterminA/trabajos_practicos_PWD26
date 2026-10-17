<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
    use SoftDeletes; //para lo de borrado logico

    use HasFactory; //para poder usar lo de factories

    protected $table = 'actividades'; //para setear como yo quiero(lo hizo la profe) el nombre de la tabla

    protected $fillable = ['titulo', 'descripcion', 'fecha', 'hora', 'cupo', 'precio', 'imagen', 'estado']; //lo de los datos masivos

    protected function casts(): array
    { //para castear tipos
        return ['fecha' => 'date', 'precio' => 'decimal:2'];
    }


    public function urlImagen(?string $ruta): ?string
    { //para lo de la imagen, donde se guarda y eso
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk('public')->url($ruta);
    }
}
