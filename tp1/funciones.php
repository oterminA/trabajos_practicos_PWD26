<?php
//este es un archivo para guardar funciones auxiliares que se repiten en distintos scritps

function esMayor($edad)
{
    $resp = false;
    if ($edad > 18) {
        $resp = true;
    }
    return $resp;
}

function darGenero($genero)
{
    switch ($genero) {
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
    return $gen;
}


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
    return $nivel;
}


function cuantosDeportes($deporte)
{
    if ($deporte) { //si es true creo que es cero la cantidad
        $cantidad = 0; //cantidad de deportes
    } else {
        $cantidad = count($deporte); //cantidad de deportes
    }
    return $cantidad;
}


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
                $resultado = -1; //no se puede 
            } else {
                $resultado = $numeroA / $numeroB;
            }
            break;
        case 'multiplicacion':
            $resultado = $numeroA * $numeroB;
            break;
    }
    return $resultado;
}
