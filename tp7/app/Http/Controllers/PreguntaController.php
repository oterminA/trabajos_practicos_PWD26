<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;


class PreguntaController extends Controller
{
    public function responder(Request $request)
    {
        $mensaje = trim(strtolower($request->input('mensaje')));

        $respuestaFinal = 'Uh bajón, no tengo respuestas para eso. Probá con los tópicos: "reseña", "subir", "película" o "cuenta".';

        $preguntas = Pregunta::orderByRaw('LENGTH(keyword) DESC')->get();

        foreach ($preguntas as $p) {
            $keyword = trim(strtolower($p->keyword));

            if ($keyword !== '' && str_contains($mensaje, $keyword)) {
                $respuestaFinal = $p->response;
                break;
            }
        }

        return response()->json(['respuesta' => $respuestaFinal]);
    }
}
