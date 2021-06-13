<?php

namespace App\Http\Controllers;
use App\Models\Suspensiones;
use App\Models\Actividades;
use App\Models\Tecnicos;
use App\Models\Cliente;
use App\Models\Correlativo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuspensionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $suspensiones = Suspensiones::all();
        return view('suspensiones/index',compact('suspensiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj_tecnicos = Tecnicos::all();
        return view('suspensiones.create', compact('obj_tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $suspension = new Suspensiones();
        $suspension->id_cliente = $request->id_cliente;
        $suspension->numero = $this->correlativo(9,6);
        $suspension->tipo_servicio = $request->tipo_servicio;
        $suspension->motivo = $request->motivo;
        $suspension->id_tecnico = $request->id_tecnico;
        $suspension->observaciones = $request->observacion;
        $suspension->id_usuario=Auth::user()->id;
        $suspension->save();
        $this->setCorrelativo(9);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Suspension creada: '.$request->id_cliente);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('suspensiones.index');
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
        $suspension = Suspensiones::find($id);
        $obj_tecnicos = Tecnicos::all();
        return view("suspensiones.edit",compact('suspension','obj_tecnicos'));
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
        Suspensiones::where('id',$request->id_suspension)->update([
            'id_tecnico'=> $request->id_tecnico,
            'motivo'=>$request->motivo,
            "fecha_trabajo"=>$fecha_trabajo,
            'observaciones'=>$request->observacion
            ]);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Orden editada con el id: '. $request->numero);
    
        return redirect()->route('suspensiones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Suspensiones::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Suspension eliminada con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('suspensiones.index');
    }

    // Autocomplete de Cliente
    public function busqueda_cliente(Request $request){
        $term1 = $request->term;
        $results = array();
            
        $queries = Cliente::Where('codigo', 'LIKE', '%'.$term1.'%')->get();
            
        foreach ($queries as $query){
            $results[] = [ 'id' => $query->id, 'value' => $query->codigo,'nombre' => $query->nombre];
        }
        return response($results);
    
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
