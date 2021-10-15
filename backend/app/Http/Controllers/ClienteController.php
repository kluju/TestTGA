<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Arriendo;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return $clientes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClientById(Request $request)
    {
        $cliente = Cliente::findOrFail($request->id);
        return $cliente;
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->rut = $request->rut;
        $cliente->name = $request->name;
        $cliente->paterno = $request->paterno;
        if($cliente->save()){
            $salida = array("code"=>"200","mensaje"=>"Guardado satisfactoriamente");
        }else{
            $salida = array("code"=>"300","mensaje"=>"No se pudo guardar");
        }
        
        return $salida;
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
        //
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
        
        $cliente = Cliente::findOrFail($request->id);
        $cliente->rut = $request->rut;
        $cliente->name = $request->name;
        $cliente->paterno = $request->paterno;
        $cliente->update();
        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cliente = Cliente::destroy($request->id);
        return $this->index();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClientIds()
    {
        
        $clientes = Cliente::select('id')->get();
        return $clientes;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClientSortByLastName()
    {
        
        $clientes = DB::select(DB::raw("
            select id FROM clientes order by paterno

        "));
        return $clientes;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClientsSortByRentExpenses()
    {
        
        $clientes = DB::select(DB::raw("
            select concat_ws(' ', clientes.name, clientes.paterno) as nombre,  sum(costo_diario * dias) suma 
            from arriendos inner join clientes on clientes.id = arriendos.id_cliente
            group by id_cliente,clientes.name order by suma desc

        "));
        return $clientes;
    }
    

    public function getClientsSortByAmount($id)
    {
        
        $clientes = DB::select(DB::raw("
                select id_empresa,rut,sum(costo_diario * dias) montogastado
                from arriendos 
                inner join clientes on clientes.id = arriendos.id_cliente
                inner join empresas  on empresas.id = arriendos.id_empresa
                where empresas.id = ".$id."
                group by id_empresa,rut
                
                HAVING montogastado > 40000
                
                order by id_empresa,montogastado desc,rut
        "));
        $salida_clientes = [];
        foreach ($clientes as $clave => $cliente) {
            $salida_clientes[$cliente->rut] = $cliente->montogastado;
        }
        
        return $salida_clientes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newClientRanking()
    {
        
        $cliente = new Cliente();
        $cliente->rut = "11111111-1";
        $cliente->name = "Danilo";
        $cliente->paterno = "Fuenzalida";
        $cliente->save();
        
        $arriendo = new Arriendo();
        $arriendo->id_cliente = $cliente->id;
        $arriendo->id_empresa = 2;
        $arriendo->costo_diario = 20000;
        $arriendo->dias = 30;
        $arriendo->save();
        return $this->getClientsSortByAmount(2);
    }


}
