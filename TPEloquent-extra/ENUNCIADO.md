# TP — Eventia: gestión de actividades

Eventia es una aplicación para administrar cursos, talleres, charlas y jornadas de una institución. El proyecto se entrega configurado con una pantalla de listado, el modelo `Actividad`, su migración y datos de ejemplo.

## Puesta en marcha

Requisitos: PHP 8.2 o superior, Composer y la extensión SQLite habilitada.

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

En Linux/macOS, reemplazar `copy` por `cp`. Luego abrir `http://127.0.0.1:8000`.

## Etapa 1 — Completar el ABM

### 1. Ver detalle

Crear la ruta `GET /actividades/{id}` y lo necesario para mostrar todos los datos de una actividad. Si el identificador no existe, la aplicación debe responder correctamente.

### 2. Crear una actividad

Crear las rutas `GET /actividades/create` y `POST /actividades`, con un formulario para título, descripción, fecha, hora, cupo, precio, estado e imagen.

Validar del lado del servidor:

- título y descripción obligatorios;
- fecha válida y hora obligatoria;
- cupo entero mayor que cero;
- precio mayor o igual que cero;
- estado: `ACTIVA`, `CANCELADA` o `FINALIZADA`;
- imagen opcional en formato JPG, PNG o WebP.

Mostrar los errores junto al formulario, conservar los valores ingresados cuando falle la validación y mostrar un mensaje al guardar correctamente.

### 3. Modificar una actividad

Crear `GET /actividades/{id}/edit` y `PUT /actividades/{id}`. El formulario debe incluir protección CSRF y enviar el método HTTP correcto. Si no se elige una imagen nueva, conservar la anterior.

### 4. Eliminar una actividad

Crear `DELETE /actividades/{id}` con una confirmación previa en la interfaz y un mensaje posterior al borrado.

### 5. Buscar y filtrar

Agregar al listado un buscador por parte del título y un filtro opcional por estado. Ambos controles deben poder combinarse y los resultados deben ordenarse por fecha. Mantener los filtros elegidos después de enviar la búsqueda.

### 6. Próximas actividades

Crear una pantalla que muestre únicamente actividades activas, con fecha igual o posterior a hoy y cupo mayor que cero, ordenadas por fecha y hora.

## Condiciones de entrega

- Utilizar Eloquent para todas las operaciones de persistencia.
- Validar siempre en el servidor.
- No modificar la estructura de la tabla salvo que se justifique.
- Mantener nombres de rutas consistentes y vistas Blade reutilizables.
