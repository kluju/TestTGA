<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\Participante;
use Illuminate\Support\Facades\DB;

class EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preguntas = DB::select(DB::raw(
            "select preg.id as id_pregunta, preg.name as pregunta, alt.id as id_respuesta, alt.name as respuesta, alt.alternativa 
            from preguntas preg  left JOIN alternativas alt on preg.id = alt.id_pregunta order by id_pregunta, id_respuesta")
        );
        //Funcion para agrupara las preguntas y respuestas
        $salida = $this->groupEncuesta($preguntas);
        return $salida ;
    }

    function groupEncuesta($preguntas)
    {
        $salida = [];
        $salida2 = [];
        $respuestas = [];
        $keySearch = "";
        foreach($preguntas as $k => $pregunta){
            if (array_key_exists($pregunta->id_pregunta, $salida)) {
                $respuestas[$pregunta->id_respuesta]["respuesta"] = $pregunta->respuesta;
                $respuestas[$pregunta->id_respuesta]["id_respuesta"] = $pregunta->id_respuesta;
            }else{
                if(count($respuestas) >0 ){
                    
                    $salida[$keySearch]["respuestas"] = array_values($respuestas) ;
                }
                $salida[$pregunta->id_pregunta]["pregunta"] = $pregunta->pregunta;
                $salida[$pregunta->id_pregunta]["id_pregunta"] = $pregunta->id_pregunta;
                if($pregunta->alternativa){
                    $respuestas = [];
                    $respuestas[$pregunta->id_respuesta]["respuesta"] = $pregunta->respuesta;
                    $respuestas[$pregunta->id_respuesta]["id_respuesta"] = $pregunta->id_respuesta;
                }
            }
            $keySearch = $pregunta->id_pregunta;
        }
        $salida = array_values($salida);
        
        return $salida;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $encuestas  = $request->encuesta;
        $participante_arr = array_filter(
            $encuestas, 
            function ($item) {
                return $item['id_pregunta'] == 1;
            }
        )[0]; 
        $participante = new Participante();
        $participante->name = $participante_arr["value"];
        $participante->save();
        
        
        foreach($encuestas as $encuesta){
            $respuesta = new Respuesta();
            $respuesta->id_pregunta = $encuesta["id_pregunta"];
            
            $respuesta->id_participante = $participante->id;
            if($encuesta["alternativa"] == "true"){
                $respuesta->id_alternativa = $encuesta["id_respuesta"];
            }else{
                $respuesta->respuesta = $encuesta["value"];
            }
            $respuesta->save();
        }

        
        $salida = array("code"=>"200","mensaje"=>"Guardado satisfactoriamente","data"=>$participante->id);
       
        
        return $salida;
        
        
    }

}
