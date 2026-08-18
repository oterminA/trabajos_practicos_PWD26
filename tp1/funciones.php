<?php
///
//este es un archivo para guardar funciones auxiliares que se repiten en distintos scritps
///

/**
 * esta funcion se usa para saber si alguien es mayor de edad.
 * recibe un entero
 * retorna booleano
 */
function esMayor($edad)
{
    $resp = false; //bandera el falso como default
    if ($edad > 18) { //si el numero ingresado por parametro es mayor que 18...
        $resp = true; /// ... se cambia la bandera 
    }
    return $resp; //se devuelve la bandera en true o false
}


/**
 * esta funcion se usa para que ingresado un género(usualmente 'F/N/OTRO') devuelva el string correspondiente
 * recibe un string
 * retorna string
 */
function darGenero($genero)
{
    switch ($genero) { //segun el string entrado por parametro evualuo ...
        case 'F':
            $gen = "femenino";
            break;

        case 'M':
            $gen = "masculino";
            break;

        default:
            $gen = "otro";
            break;
    }
    return $gen; //devuelvo la variable con el string
}

/**
 * esta funcion se usa para que ingresado un nivel de estudios en string devuelva el string correspondiente
 * recibe un string
 * retorna string
 */
function estudioAlcanzado($estudio)
{
    switch ($estudio) {
        case 'sin_est':
            $nivel = "incompleto";
            break;

        case 'est_prim':
            $nivel = "estudios primarios";
            break;

        case 'est_sec':
            $nivel = "estudios secundarios";
            break;

        case 'est_uni':
            $nivel = "estudios universitarios";
            break;
    }
    return $nivel; //retorna la variable con el valor string 
}

/**
 * esta funcion se usa para que ingresado un array dice cuántos elementos hay en ese array
 * recibe un array
 * retorna integer
 */
function cuantosDeportes($deporte)
{
    //entra por parametro un arreglo de opciones en checkbox y quiero saber cuántas opciones fueron marcadas

    if ($deporte) { //si es true creo que es cero la cantidad porque en el script php hice '$deportes = empty($_POST["opciones"]);' lo que estaría diciendo que es true que está vacío entonces le asigno 0 como cantidad de deportes practicados
        $cantidad = 0; //cantidad de deportes
    } else {
        $cantidad = count($deporte); //cantidad de deportes que cliqueó el usuario
    }
    return $cantidad; //retorno la cantidad
}

/**
 * esta funcion se usa para hacer la operación matemática que pide el usuario
 * recibe un array perteneciente a un select que tiene strings y dos elementos float
 * retorna integer
 */
function hacerOperacion($operacion, $numeroA, $numeroB)
{
    switch ($operacion) {
        case 'suma':
            $resultado = $numeroA + $numeroB;
            break;
        case 'resta':
            $resultado = $numeroA - $numeroB;
            break;
        case 'division':
            if ($numeroB === 0) {
                $resultado = -1; //no se puede dividir por cero
            } else {
                $resultado = $numeroA / $numeroB;
            }
            break;
        case 'multiplicacion':
            $resultado = $numeroA * $numeroB;
            break;
    }
    return $resultado; //retorna el float/integer como resultado
}
