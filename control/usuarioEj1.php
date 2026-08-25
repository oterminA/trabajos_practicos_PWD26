<?php
class usuarioEj1
{

    /**
     * funcion que revisa si las credenciales ingresadas en el formulario son correctas
     * recibe arreglo de datos usuario-clave
     * retorna boolean
     */
    function usuarioExistente($datos)
    {
        $encontrado = false; //bandera en falso por defecto
        $i = 0; //contador de bucle en cero
        $arregloUsuarios = [ //arreglo de usuarios prearmados
            ['usuario' =>  'caro!', 'clave' => '01010101'],
            ['usuario' => 'usuario*', 'clave' => 'contrasen1a'],
            ['usuario' => 'mengano', 'clave' => 'mengano01']
        ];
        $usuarioDatos = $datos["usuario"]; //del array que entra por parametro recupero el usuario
        $claveDatos = $datos["clave"];//del array que entra por parametro recupero la clave
        $cantidadUsers = count($arregloUsuarios); //para el bucle saco la cantidad de elementos del arreglo de usuarios
        while (($i < $cantidadUsers) && !$encontrado) { //itero mientras no se pase de la cantidad de elementos y mientras no se encuentre el user
            $cuenta = $arregloUsuarios[$i]; //recupero un usuario del arreglo
            $cuentaUsuario = $cuenta["usuario"]; //recupero de ese arreglo el usuario
            $cuentaClave = $cuenta["clave"];//recupero de ese arreglo la clave
            if ($cuentaUsuario === $usuarioDatos && $cuentaClave === $claveDatos) { //si todo coincide
                $encontrado = true; //cambio el valor de la variable
            }
            $i++; //aumento el contador
        }
        return $encontrado; //retorno un boolean
    }
}
