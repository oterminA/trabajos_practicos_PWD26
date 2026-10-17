<?php

namespace Database\Seeders;

use App\Models\Actividad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ActividadSeeder extends Seeder
{
    public function run(): void
    {
        $hoy = Carbon::today();
        $actividades = [
            ['Curso de fotografía digital', 'Aprendé composición, iluminación y edición básica mediante ejercicios prácticos.', 7, '18:00', 24, 18500, 'ACTIVA'],
            ['Introducción a Python', 'Primeros pasos en programación con variables, estructuras de control y funciones.', 14, '17:30', 30, 22000, 'ACTIVA'],
            ['Taller de impresión 3D', 'Diseño, laminado y fabricación de una pieza sencilla en el laboratorio maker.', 21, '10:00', 16, 15000, 'ACTIVA'],
            ['Jornada de Ciberseguridad', 'Buenas prácticas para reconocer riesgos y proteger información personal.', 30, '09:00', 80, 0, 'ACTIVA'],
            ['Diseño de interfaces con Figma', 'Prototipado de una aplicación desde el boceto hasta una interfaz navegable.', 10, '19:00', 20, 12500, 'ACTIVA'],
            ['Huerta urbana', 'Planificación de cultivos de estación para patios, terrazas y balcones.', 18, '09:30', 18, 8000, 'ACTIVA'],
            ['Oratoria y presentaciones', 'Recursos para organizar ideas y hablar frente a distintos públicos.', 25, '18:30', 28, 10500, 'ACTIVA'],
            ['Laboratorio de escritura creativa', 'Ejercicios de narración breve, lectura y devolución grupal.', 35, '17:00', 15, 14000, 'ACTIVA'],
            ['Charla: Inteligencia artificial y sociedad', 'Un encuentro abierto para pensar oportunidades, límites y desafíos actuales.', 4, '20:00', 120, 0, 'CANCELADA'],
            ['Excel para la gestión', 'Fórmulas, tablas y gráficos aplicados a situaciones administrativas.', 42, '16:00', 25, 19500, 'ACTIVA'],
            ['Primeros auxilios', 'Procedimientos iniciales ante emergencias cotidianas hasta la llegada de ayuda.', 12, '08:30', 0, 6000, 'ACTIVA'],
            ['Robótica para principiantes', 'Armado y programación de un prototipo con sensores y actuadores.', 50, '10:30', 20, 26000, 'ACTIVA'],
            ['Seminario de comunicación institucional', 'Estrategias y herramientas para planificar la comunicación de organizaciones.', -8, '18:00', 35, 9000, 'FINALIZADA'],
            ['Taller de podcast', 'Guion, grabación y edición de una pieza sonora breve.', -18, '17:30', 14, 11000, 'FINALIZADA'],
            ['Jornada de software libre', 'Experiencias, demostraciones y comunidades en torno al software libre.', 60, '09:00', 100, 0, 'ACTIVA'],
        ];

        foreach ($actividades as [$titulo, $descripcion, $dias, $hora, $cupo, $precio, $estado]) {
            Actividad::create([
                'titulo' => $titulo, 'descripcion' => $descripcion,
                'fecha' => $hoy->copy()->addDays($dias), 'hora' => $hora,
                'cupo' => $cupo, 'precio' => $precio, 'imagen' => null, 'estado' => $estado,
            ]);
        }
    }
}
