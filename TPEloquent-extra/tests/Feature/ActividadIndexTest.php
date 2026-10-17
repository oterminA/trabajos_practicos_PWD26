<?php

namespace Tests\Feature;

use App\Models\Actividad;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActividadIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_raiz_redirige_al_listado(): void
    {
        $this->get('/')->assertRedirect('/actividades');
    }

    public function test_el_listado_muestra_las_actividades_ordenadas_por_fecha(): void
    {
        Actividad::create(['titulo'=>'Actividad posterior','descripcion'=>'Descripción de prueba','fecha'=>'2030-05-20','hora'=>'18:00','cupo'=>10,'precio'=>0,'estado'=>'ACTIVA']);
        Actividad::create(['titulo'=>'Actividad anterior','descripcion'=>'Descripción de prueba','fecha'=>'2030-05-10','hora'=>'10:00','cupo'=>10,'precio'=>1000,'estado'=>'ACTIVA']);

        $this->get('/actividades')->assertOk()->assertSeeInOrder(['Actividad anterior', 'Actividad posterior']);
    }
}
