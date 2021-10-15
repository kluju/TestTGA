<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta;
use Illuminate\Support\Facades\DB;
class RespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respuestas = DB::select(DB::raw("
        SELECT
        res.id_participante,
        preg.NAME AS pregunta,
        alt.NAME AS respuesta,
        res.id_alternativa,
        res.respuesta as text_resp
        FROM
            respuestas res
            INNER JOIN preguntas preg ON res.id_pregunta = preg.id
            LEFT JOIN alternativas alt ON res.id_alternativa = alt.id
            
            order by res.id_participante,preg.id
            "));
        
        return $respuestas ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBusinessById(Request $request)
    {
        $respuesta = Respuesta::findOrFail($request->id);
        return $respuesta;
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $respuesta = new Respuesta();
        $respuesta->id_pregunta = $request->id_pregunta;
        $respuesta->id_alternativa = $request->id_pregunta;
        $respuesta->id_participante = $request->id_pregunta;
        $respuesta->respuesta = $request->respuesta;

        $respuesta->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $respuesta = DB::table('respuestas')->where('id_participante', '=', $id)->get();
        $participante = DB::table('participantes')->where('id', '=', $id)->first();
        return array("respuestas"=>$respuesta,"participante"=>$participante);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $respuesta = Respuesta::findOrFail($request->id);
        $respuesta->name = $request->name;
        $respuesta->save();
        return $respuesta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $respuesta = Respuesta::destroy($request->id);
        return $this->index();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graficoGenero()
    {
        
        $respuestas = DB::select(DB::raw("select alt.name,alt.id,count(res.id_alternativa) as cantidad from alternativas alt
                    left JOIN respuestas res on res.id_alternativa = alt.id
                where alt.id_pregunta = 2
                GROUP BY alt.name,alt.id"
        ));
        
        return $respuestas ;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graficoHobby()
    {
        
        $respuestas = DB::select(DB::raw("select alt.name,alt.id,count(res.id_alternativa) as cantidad from alternativas alt
                    left JOIN respuestas res on res.id_alternativa = alt.id
                where alt.id_pregunta = 3
                GROUP BY alt.name,alt.id"
        ));
        
        return $respuestas ;
        
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graficoNombres()
    {
        
        $respuestas = DB::select(DB::raw("
                select preg.id,count(res.respuesta) as cantidad,res.respuesta as name from preguntas preg
                left JOIN respuestas res on preg.id= res.id_pregunta
                where preg.id = 1
                GROUP BY res.respuesta,preg.id"
        ));
        
        return $respuestas ;
        
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graficoTiempoDedicado()
    {
        
        $respuestas = DB::select(DB::raw("
                select preg.id,count(res.respuesta) as cantidad,res.respuesta as name from preguntas preg
                left JOIN respuestas res on preg.id= res.id_pregunta
                where preg.id = 4
                GROUP BY res.respuesta,preg.id"
        ));
        
        return $respuestas ;
        
    }
    
    function groupRespuestas($preguntas)
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function excel()
    {
       $respuestas = DB::select(DB::raw("
            SELECT res.id_participante,preg.NAME AS pregunta,alt.NAME AS respuesta,res.id_alternativa,res.respuesta as text_resp
            FROM
            respuestas res
            INNER JOIN preguntas preg ON res.id_pregunta = preg.id
            LEFT JOIN alternativas alt ON res.id_alternativa = alt.id
            order by res.id_participante,preg.id
            "));
        $filename = "respuestas.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=".$filename);
                
        echo "<table>";
        echo "<tr>";
        echo "<th>";
        echo "Pregunta";
        echo "</th>";
        echo "<th>";
        echo "Respuesta";
        echo "</th>";
        echo "</tr>";
                

        foreach($respuestas as $resp) {
            echo "<tr>";
            echo "<td>";
            echo $resp->pregunta;
            echo "</td>";
            echo "<td>";
            echo $resp->respuesta ? $resp->respuesta : $resp->text_resp;
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit;
                
                
    }
}
