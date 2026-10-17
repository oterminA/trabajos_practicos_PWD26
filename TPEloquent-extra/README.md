# Eventia

Proyecto educativo progresivo construido con Laravel y Eloquent. La aplicación administra actividades de una institución y se entrega con el listado inicial ya resuelto para que los estudiantes completen el ABM y consultas más elaboradas.

- [Enunciado para estudiantes](ENUNCIADO.md)
- [Guía docente](GUIA_DOCENTE.md)

## Inicio rápido

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Abrir `http://127.0.0.1:8000`. En Linux/macOS usar `cp` en lugar de `copy`.

## Pruebas

```bash
php artisan test
```

No necesita compilar recursos front-end: los estilos se sirven directamente desde `public/css/eventia.css`.
