<?php
class cineEj2
{
    /**
     * funcion para formatear el texto de genero de pelicula
     * recibe un string
     * retorna string
     */
    function mostrarGenero($gen)
    {
        switch ($gen) {
            case 'comedia':
                $genero = "comedia";
                break;

            case 'terror':
                $genero = "terror";
                break;

            case 'romantica':
                $genero = "romantica";
                break;

            case 'suspenso':
                $genero = "suspenso";
                break;

            case 'otro':
                $genero = "no se encuentra en la lista";
                break;
        }
        return $genero;
    }

    /**
     * funcion para formatear el texto de restriccion de edad
     * recibe un string
     * retorna string
     */
    function mostrarRestriccion($restriccion)
    {
        switch ($restriccion) {
            case 'todos':
                $edad = "apta para todo público";
                break;

            case 'may7':
                $edad = "apta para mayores de 7 años";
                break;

            case 'may18':
                $edad = "apta para mayores de 18 años";
                break;

            default:
                $edad = "error";
                break;
        }
        return $edad;
    }

    /** 
     * esta funcion retorna formateados los datos que ingresaron por parametro
     * recibe un array de datos
     * retorna una variable con string dentro
     */
    function mostrarDatos($datos)
    {
        $restriccion = $this->mostrarRestriccion($datos["restriccion"] ?? ''); //mando la restriccion de edad a la funcion que formatea el texto
        $genero = $this->mostrarGenero($datos["genero"] ?? '');//mando el genero a la funcion que formatea el texto
        $titulo = $datos["titulo"] ?? '';
        $actores = $datos["actores"] ?? '';
        $director = $datos["director"] ?? '';
        $guion = $datos["guion"] ?? '';
        $produccion = $datos["produccion"] ?? '';
        $anio = $datos["anio"] ?? '';
        $nacionalidad = $datos["nacionalidad"] ?? '';
        $duracion = $datos["duracion"] ?? '';
        $sinopsis = $datos["sinopsis"] ?? '';

        $mensaje = //armo el string que se devuelve
            "<b>Titulo</b>: " . $titulo . "<br>" .
            "<b>Actores</b>: " . $actores . "<br>" .
            "<b>Director</b>: " . $director . "<br>" .
            "<b>Guión</b>: " . $guion . "<br>" .
            "<b>Producción</b>: " . $produccion . "<br>" .
            "<b>Año</b>: " . $anio . "<br>" .
            "<b>Nacionalidad</b>: " . $nacionalidad . "<br>" .
            "<b>Genero</b>: " . $genero . "<br>" .
            "<b>Duración</b>: " . $duracion .  " minutos" . "<br>" .
            "<b>Restricción por edad</b>: " . $restriccion . "<br>" .
            "<b>Sinopsis</b>: '" . $sinopsis . "'" . "<br>";
        return $mensaje;
    }
}
