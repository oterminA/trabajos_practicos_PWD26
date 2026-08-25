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
        $restriccion = $this->mostrarRestriccion($datos["restriccion"]); //mando la restriccion de edad a la funcion que formatea el texto
        $genero = $this->mostrarGenero($datos["genero"]);//mando el genero a la funcion que formatea el texto
        $titulo = $datos["titulo"] ?? '';;
        $actores = $datos["actores"] ?? '';;
        $director = $datos["director"] ?? '';;
        $guion = $datos["guion"] ?? '';;
        $produccion = $datos["produccion"] ?? '';;
        $anio = $datos["anio"] ?? '';;
        $nacionalidad = $datos["nacionalidad"] ?? '';;
        $duracion = $datos["duracion"] ?? '';;
        $sinopsis = $datos["sinopsis"] ?? '';;

        $mensaje = //armo el string que se devuelve
            "Titulo: " . $titulo . "<br>" .
            "Actores: " . $actores . "<br>" .
            "Director: " . $director . "<br>" .
            "Guion: " . $guion . "<br>" .
            "Produccion: " . $produccion . "<br>" .
            "Año: " . $anio . "<br>" .
            "Nacionalidad: " . $nacionalidad . "<br>" .
            "Genero: " . $genero . "<br>" .
            "Duración: " . $duracion .  " minutos" . "<br>" .
            "Restriccion por edad: " . $restriccion . "<br>" .
            "Sinopsis: '" . $sinopsis . "'" . "<br>";
        return $mensaje;
    }
}
