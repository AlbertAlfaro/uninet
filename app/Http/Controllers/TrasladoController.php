<?php

namespace App\Http\Controllers;
use App\Models\Traslados;
use App\Models\Actividades;
use App\Models\Tecnicos;
use App\Models\Cliente;
use App\Models\Correlativo;
use App\Models\Departamentos;
use App\Models\Municipios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traslados = Traslados::all();
        return view('traslados/index',compact('traslados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj_tecnicos = Tecnicos::all();
        $obj_departamentos = Departamentos::all();
        return view('traslados.create', compact('obj_tecnicos','obj_departamentos'));

        
    }
    public function municipios($id){

        $municipios = Municipios::where('id_departamento',$id)->get();
       return response()->json(
            $municipios-> toArray()  
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $traslado = new Traslados();
        $traslado->id_cliente = $request->id_cliente;
        $traslado->numero = $this->correlativo(7,6);
        $traslado->tipo_servicio = $request->tipo_servicio;
        $traslado->id_tecnico = $request->id_tecnico;
        $traslado->id_municipio = $request->id_municipio;
        $traslado->nueva_direccion = $request->nuevadirec;
        $traslado->observacion = $request->observacion;
        $traslado->id_usuario=Auth::user()->id;
        $traslado->save();
        $this->setCorrelativo(7);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Traslado creado: '.$request->id_cliente);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('traslados.index');
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
        $traslado = Traslados::find($id);
        $obj_tecnicos = Tecnicos::all();
        $obj_departamentos = Departamentos::all();
        return view("traslados.edit",compact('traslado','obj_tecnicos','obj_departamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fecha_trabajo="";
        if($request->fecha_trabajo!=""){
            $fecha_trabajo = Carbon::createFromFormat('d/m/Y', $request->fecha_trabajo);

        }
        Traslados::where('id',$request->id_traslado)->update([
            'id_tecnico'=> $request->id_tecnico,
            'id_municipio'=>$request->id_municipio,
            'nueva_direccion'=>$request->nuevadirec,
            "fecha_trabajo"=>$fecha_trabajo,
            "rx"=>$request->rx,
            "tx"=>$request->tx,
            'observacion'=>$request->observacion
            ]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Traslado editada con el id: '. $request->numero);
    
        return redirect()->route('traslados.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
    private function correlativo($id,$digitos){
        //id correlativo 
        /*
            1 cof
            2 ccf 
            3 cliente
            4 tv 
            5 inter
            6 orden 
            7 traslado
            8 reconexion
            9 suspension
        */

        $correlativo = Correlativo::find($id);
        $ultimo = $correlativo->ultimo+1;

        return $this->get_correlativo($ultimo,$digitos);

    }
    private function setCorrelativo($id){

        //id correlativo 
        /*
            1 cof
            2 ccf 
            3 cliente
            4 tv 
            5 inter
            6 orden 
            7 traslado
            8 reconexion
            9 suspension
        */
        $correlativo = Correlativo::find($id);
        $ultimo = $correlativo->ultimo+1;
        Correlativo::where('id',$id)->update(['ultimo' =>$ultimo]);
    }
    private function get_correlativo($ult_doc,$long_num_fact){
        $ult_doc=trim($ult_doc);
        $len_ult_valor=strlen($ult_doc);
        $long_increment=$long_num_fact-$len_ult_valor;
        $valor_txt="";
        if ($len_ult_valor<$long_num_fact) {
            for ($j=0;$j<$long_increment;$j++) {
            $valor_txt.="0";
            }
        } else {
            $valor_txt="";
        }
        $valor_txt=$valor_txt.$ult_doc;
        return $valor_txt;
    }
}
