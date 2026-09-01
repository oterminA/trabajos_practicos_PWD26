<?php
class textoEj4
{
    /** 
     * esta funcion recibe y controla un archivo pdf o doc subido por un formulario
     * recibe un array o un archivo pdf/doc
     * retorna strings
     */
    function recibirTexto($datos)
    {
        $respuesta = [ //array que muestra el link al archivo, el mensaje según el exito y el boolean de exito para saber de una que pasó
            'exito' => false,
            'mensaje' => '',
            'contenido' => ''
        ];


        //revisar que el archivo llegó 
        if (!isset($datos['archivo']) || empty($datos['archivo']['name'])) { //reviso si no es null el contenido de archivos y si no está vacío
            $respuesta['mensaje'] = "ERROR: No se recibió ningún archivo."; //si lo es guardo ese texto en el array
        }

        $archivo = $datos['archivo']; //recupero el archivo

        //revisar erroers nativos de php cuando se sube el archivo
        if ($archivo['error'] !== UPLOAD_ERR_OK) { //acá me fijo si el codigo de error es distinto de cero(si no lo es significa que hubo error porque cuando falla 'error' me da cero y lo siguiente es un codigo que significa cero)
            $respuesta['mensaje'] = "ERROR: ocurrió un error."; //acá guardo en el array el mensaje de error + el codigo de error traducido
        }

        // revisar el tamaño del archivo en este caso es de 2mb el maximo
        $maxTamanio = 2 * 1024 * 1024; //esto resulta en 2mb
        if ($archivo['size'] > $maxTamanio) { //size es el tamaño en bytes
            $respuesta['mensaje'] = "ERROR: El tamaño del archivo no puede ser mayor a 2mb."; //mando el mensaje de error
        }

        //revisar la extensión del archivo, no confiar en la extension
        $extension = mime_content_type($archivo['tmp_name']);
        $extPermitidas = [ //acá busco la extension dela archivo subido usando la ruta temporal porque todavia no está subido a la definitiva
            'text/plain' // esto es .txt
        ];

        if (!in_array($extension, $extPermitidas, true)) { //acá reviso si la extensión del archivo NO está dentro de las permititidas
            $respuesta['mensaje'] = "ERROR: Formato no permitido. El archivo debe ser un PDF o DOC."; //guardo el mensaje de error
        }

        //hacer lo de la carpeta destino usando la ruta absoluta del proyecto
        $nombreOriginal = basename($archivo['name']); //recupero el nombre del archivo, o sea el nombre original
        $directorioDestino = $GLOBALS['ROOT'] . "uploads/"; //guardo acá la ruta raíz del proyecto + la carpetadonnde quiero guardar los archivos

        if (!is_dir($directorioDestino)) { //si lo anterior no es un directorio o sea no existe la carpeta que yo dije
            if (!mkdir($directorioDestino, 0777, true)) { //entonces reviso si NO se puede crear otra vez con los permisos
                $respuesta['mensaje'] = "ERROR: No se pudo crear el directorio de destino en el servidor."; //si no se pudo guardo el msj de error
            }
        }

        $rutaAbsolutaDestino = $directorioDestino . $nombreOriginal; //acá guardo el lugar donde va a quedar el archivo y el nombre que vino cuando se subió

        //mover el archivo
        if (move_uploaded_file($archivo['tmp_name'], $rutaAbsolutaDestino)) {
            //configuro los arreglos si todo salió bien
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = "Subido al servidor";
            $respuesta['contenido'] =  file_get_contents($rutaAbsolutaDestino);
        } else { //si no se pudo mover a la ubicacion final guardo el mensaje de error
            $respuesta['mensaje'] = "ERROR: No se pudo guardar el archivo en el servidor.";
        }

        return $respuesta; //retorno el arreglo con las respuestas necesarias
    }
}
