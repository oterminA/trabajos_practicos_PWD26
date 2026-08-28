<?php
//revisar el archivo txt en configuración sobre cosas a tener en cuenta con archivos y subidas

/*PREGUNTA: es necesario hacer eso que hizo la profe de:
private function directorioUploads()
    {
        return $GLOBALS['ROOT'] . "uploads/";
    }
        
o hacer lo de: 
 private function mensajeErrorUpload($codigo, $tipoArchivo)
 ?
*/
class portadaEj4
{
    /** 
     * esta funcion recibe y controla un archivo pdf o doc subido por un formulario
     * recibe un array o un archivo pdf/doc
     * retorna strings
     */
    function recibirImagen($imagen)
    {
       $respuesta = [
            'exito' => false,
            'mensaje' => '',
            'link' => '',
            'contenido' => ''
        ];

        // rvisar que la imagen si llegó
        if (!isset($imagen) || empty($imagen['name'])) { //reviso si es null la imagen y si está vacia
            $respuesta['mensaje'] = "ERROR: No se recibió ningún archivo de imagen."; //si lo es guardo el msj de error en el array
        }

        // revisar errores de php
        if ($imagen['error'] !== UPLOAD_ERR_OK) { //acá me fijo si el codigo de error es distinto de cero(si no lo es significa que hubo error porque cuando falla 'error' me da cero y lo siguiente es un codigo que significa cero)
            $respuesta['mensaje'] = "ERROR."; //guardo msj de error
        }

        //revisar tamaño maximo acá es 300kb
        $maxTamanio = 300 * 1024;
        if ($imagen['size'] > $maxTamanio) {
            $respuesta['mensaje'] = "ERROR: La imagen excede el tamaño máximo permitido de 300 KB.";
        }

        //revisar la extension de las imagenes
        $mimeImagen = mime_content_type($imagen['tmp_name']);
        $tiposPermitidos = [ //acá busco la extension del archivo subido usando la ruta temporal porque todavia no está subido a la definitiva
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ];

        if (!in_array($mimeImagen, $tiposPermitidos, true)) {//acá reviso si la extensión del archivo NO está dentro de las permititidas
            $respuesta['mensaje'] = "ERROR: Formato no permitido. La imagen debe ser JPG, PNG, GIF o WEBP.";//guardo ese msj de error
        }

        //hacer lo de la carpeta destino usando la ruta absoluta del proyecto
        $nombreOriginal = basename($imagen['name']); //recupero el nombre del archivo, es decir el que le puso el cliente
        $directorioDestino = $GLOBALS['ROOT'] . "uploads/"; //guardo acá la ruta raíz del proyecto + la carpeta donde quiero guardar los archivos

        if (!is_dir($directorioDestino)) { //si la carpeta indicada no existe, la tengo que crear en esta instancia
            if (!mkdir($directorioDestino, 0777, true)) {//entonces reviso si NO se puede crear otra vez con los permisos
                $respuesta['mensaje'] = "ERROR: No se pudo crear el directorio de destino en el servidor.";//si no se pudo guardo el msj de error
            }
        }

        $rutaAbsolutaDestino = $directorioDestino . $nombreOriginal; //acá guardo el lugar donde va a quedar el archivo y el nombre que vino cuando se subió
        $rutaRelativaLink = "../uploads/" . $nombreOriginal;

        //mover la iamgen de forma final
        if (move_uploaded_file($imagen['tmp_name'], $rutaAbsolutaDestino)) {//configuro los arreglos si todo salió bien
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = "Se subió la imagen al servidor.";
            $respuesta['link'] = $rutaRelativaLink; //por si hay que mostrar el link
            $respuesta['contenido'] = $rutaRelativaLink; //esto es para mostrar la imagen
        } else {
            $respuesta['mensaje'] = "ERROR: No se pudo guardar la imagen en el servidor.";
        }

        return $respuesta;
    }
}
