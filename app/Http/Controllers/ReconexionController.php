<?php

namespace App\Http\Controllers;
use App\Models\Reconexion;
use App\Models\Actividades;
use App\Models\Tecnicos;
use App\Models\Cliente;
use App\Models\Correlativo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReconexionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reconexiones = Reconexion::all();
        return view('reconexiones/index',compact('reconexiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj_tecnicos = Tecnicos::all();
        return view('reconexiones.create', compact('obj_tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        
        $reconexion = new Reconexion();
        $reconexion->id_cliente = $request->id_cliente;
        $reconexion->numero = $this->correlativo(8,6);
        $reconexion->tipo_servicio = $request->tipo_servicio;
        $reconexion->id_tecnico = $request->id_tecnico;
        $reconexion->contrato = $request->input('contrato');
        $reconexion->observacion = $request->observacion;
        $reconexion->id_usuario=Auth::user()->id;
        $reconexion->save();
        $this->setCorrelativo(8);

        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Reconexion creada: '.$request->id_cliente);

        flash()->success("Registro creado exitosamente!")->important();
        return redirect()->route('reconexiones.index');
        
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
        $reconexion = Reconexion::find($id);
        $obj_tecnicos = Tecnicos::all();
        return view("reconexiones.edit",compact('reconexion','obj_tecnicos'));
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
        $fecha_trabajo=null;
        if($request->fecha_trabajo!=""){
            $fecha_trabajo = Carbon::createFromFormat('d/m/Y', $request->fecha_trabajo);

        }
        Reconexion::where('id',$request->id_reconexion)->update([
            'id_tecnico'=> $request->id_tecnico,
            'observacion'=>$request->observacion,
            'fecha_trabajo'=>$fecha_trabajo,
            'contrato'=>$request->input('contrato'),
            'n_contrato'=>$request->n_contrato,
            'rx'=>$request->rx,
            'tx'=>$request->tx,
            ]);

        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Reconexion editada: '. $request->numero);
    
        return redirect()->route('reconexiones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reconexion::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Reconexion eliminada con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('reconexiones.index');
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
    
        private function actividar_cliente($id){
    
            $reconexion = Reconexion::find($id);
            $servicio = $reconexion->tipo_servicio;
            if($servicio=="Internet")
            {
                Cliente::where('id',$reconexion->id_cliente)->update(['internet' =>'1']);
                
            }
            if($servicio=="Tv")
            {
                Cliente::where('id',$reconexion->id_cliente)->update(['tv' =>'1']);
            }
            
        }
}