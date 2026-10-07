# Guía docente — Eventia

## Qué se entrega resuelto

- Laravel 12 configurado para mysql.
- Migración y modelo `Actividad` con asignación masiva y casts.
- Seeder con 15 casos variados y fechas relativas al día de ejecución.
- `ActividadController@index`, ruta del listado, layout y vista responsive.
- Dos pruebas de referencia sobre el comportamiento inicial.

El texto para estudiantes está en `ENUNCIADO.md`. Este archivo puede retirarse antes de distribuir el proyecto.

## Secuencia sugerida

1. Recorrido de la estructura y lectura de `index()`: modelo, controlador, ruta y vista.
2. Detalle y manejo de registros inexistentes.
3. Alta con validación y mensajes de sesión.
4. Edición, method spoofing y conservación de imagen.
5. Baja y confirmación.
6. Consultas encadenadas: búsqueda, estado y próximas actividades.
7. Refactor: Form Requests, componentes Blade y route model binding.

## Rúbrica sugerida (100 puntos)

| Aspecto | Puntos |
|---|---:|
| Detalle y manejo de inexistentes | 10 |
| Alta y validación de servidor | 20 |
| Modificación y conservación de imagen | 20 |
| Eliminación segura | 10 |
| Búsqueda y filtro combinables | 15 |
| Consulta de próximas actividades | 15 |
| Calidad, reutilización y experiencia de uso | 10 |

## Extensiones para clases posteriores

- **1:N:** agregar una categoría y relacionarla con muchas actividades.
- **N:N:** participantes e inscripciones, con fecha y estado en la tabla pivote.
- **AJAX:** cambiar estado o buscar sin recargar la página.
- **Seguridad:** autenticación, autorización por roles y protección de acciones.
- **API:** exponer actividades próximas como recurso JSON.

Conviene guardar una copia limpia de este punto de partida y que cada etapa se entregue mediante commits separados. Los casos del seeder incluyen actividades finalizadas, una cancelada, una sin cupo y gratuitas para comprobar las consultas sin alterar datos a mano.
