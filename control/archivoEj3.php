<?php
//revisar el archivo txt en configuración sobre cosas a tener en cuenta con archivos y subidas
class archivoEj3
{
    /** 
     * esta funcion recibe y controla un archivo pdf o doc subido por un formulario
     * recibe un array o un archivo pdf/doc
     * retorna strings
     */
    function recibirArchivo($datos)
    {
        $respuesta = [ //array de respuestas
            'exito' => false,
            'mensaje' => '',
            'link' => ''
        ];

        //revisar que el archivo llegó 
        if (!isset($datos['archivo']) || empty($datos['archivo']['name'])) {
            $respuesta['mensaje'] = "ERROR: No se recibió ningún archivo.";
        }

        $archivo = $datos['archivo'];

        //revisar erroers nativos de php cuando se sube el archivo
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $respuesta['mensaje'] = "ERROR: " . $this->mensajesDeError($archivo['error']);
        }

        // revisar el tamaño del archivo en este caso es de 2mb el maximo
        $maxTamanio = 2 * 1024 * 1024;
        if ($archivo['size'] > $maxTamanio) {
            $respuesta['mensaje'] = "ERROR: El tamaño del archivo no puede ser mayor a 2mb.";
        }

        //revisar la extensión del archivo, no confiar en la extension
        $mimeType = mime_content_type($archivo['tmp_name']);
        $mimesPermitidos = [
            'application/pdf',
            'application/msword' // .doc
            // 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // .docx (opcional)
        ];

        if (!in_array($mimeType, $mimesPermitidos, true)) {
            $respuesta['mensaje'] = "ERROR: Formato no permitido. El archivo debe ser un PDF o DOC.";
        }

        //hacer lo de la carpeta destino usando la ruta absoluta del proyecto
        $nombreOriginal = basename($archivo['name']);
        $directorioDestino = $GLOBALS['ROOT'] . "uploads/";

        if (!is_dir($directorioDestino)) {
            if (!mkdir($directorioDestino, 0777, true)) {
                $respuesta['mensaje'] = "ERROR: No se pudo crear el directorio de destino en el servidor.";
            }
        }

        $rutaAbsolutaDestino = $directorioDestino . $nombreOriginal;
        $rutaRelativaLink = "../uploads/" . $nombreOriginal;

        //mover el archivo
        if (move_uploaded_file($archivo['tmp_name'], $rutaAbsolutaDestino)) {
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = "Subido al servidor";
            $respuesta['link'] = $rutaRelativaLink;
        } else {
            $respuesta['mensaje'] = "ERROR: No se pudo guardar el archivo en el servidor.";
        }

        return $respuesta;
    }

    /**
     * esta funcion traduce los codigos numericos que tira php
     */
    private function mensajesDeError($codigo)
    {
        $resp = '';
        switch ($codigo) {
            case UPLOAD_ERR_FORM_SIZE:
                $resp = "El archivo subido supera el tamaño límite configurado en el servidor.";
            case UPLOAD_ERR_PARTIAL:
                $resp = "El archivo solo se subió parcialmente.";
            case UPLOAD_ERR_NO_FILE:
                $resp = "No se seleccionó ningún archivo.";
            case UPLOAD_ERR_NO_TMP_DIR:
                $resp = "Falta la carpeta temporal en el servidor.";
            case UPLOAD_ERR_CANT_WRITE:
                $resp = "No se pudo escribir el archivo en el disco.";
            default:
                $resp = "Ocurrió un error inesperado al subir el archivo.";
        }
        return $resp;
    }
}
