<?php

namespace App\Http\Controllers;
use App\Fpdf\FpdfClass;
use App\Models\Traslados;
use App\Models\Actividades;
use App\Models\Tecnicos;
use App\Models\Cliente;
use App\Models\Correlativo;
use App\Models\Internet;
use App\Models\Tv;
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
    public function __construct(){
        // verifica si la session esta activa
        $this->middleware('auth');
    }
    public function index()
    {
        $traslados = Traslados::all();
        $id_cliente=0;
        return view('traslados/index',compact('traslados','id_cliente'));
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
        $id_cliente=0;
        return view('traslados.create', compact('obj_tecnicos','obj_departamentos','id_cliente'));

        
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
    {   if($request->tipo_servicio=="Internet")
        {   $cliente=Cliente::where('id',$request->id_cliente)->where('internet','1')->get();
            if(count($cliente)>0)
            {
                $traslado = new Traslados();
                $traslado->id_cliente = $request->id_cliente;
                $traslado->numero = $this->correlativo(7,6);
                $traslado->tipo_servicio = $request->tipo_servicio;
                $traslado->id_tecnico = $request->id_tecnico;
                $traslado->id_municipio = $request->id_municipio;
                $traslado->nueva_direccion = $request->nuevadirec;
                $traslado->observacion = $request->observacion;
                $traslado->update_direc = 0;
                $traslado->id_usuario=Auth::user()->id;
                $traslado->save();
                $this->setCorrelativo(7);
                
                //obteniendo el ultimo traslado
                $ultimo_traslado = Traslados::all()->last();
                $numero = $ultimo_traslado->numero;
                
                $obj_controller_bitacora=new BitacoraController();	
                $obj_controller_bitacora->create_mensaje('Traslado creado: '.$numero);
        
                flash()->success("Registro creado exitosamente!")->important();
               
                if($request->di==0){
        
                    return redirect()->route('traslados.index');
                }else{
                    return redirect()->route('cliente.traslados.index',$request->id_cliente);
                }
            }else
            {  
                flash()->error("Cliente No posee Internet activo!")->important();
                if($request->di==0){
        
                    return redirect()->route('traslados.create');
                }else{
                    return redirect()->route('cliente.traslados.create',$request->id_cliente);
                }
            }
        }
        if($request->tipo_servicio=="Tv")
        {   $cliente=Cliente::where('id',$request->id_cliente)->where('tv','1')->get();
            if(count($cliente)>0)
            {
                $traslado = new Traslados();
                $traslado->id_cliente = $request->id_cliente;
                $traslado->numero = $this->correlativo(7,6);
                $traslado->tipo_servicio = $request->tipo_servicio;
                $traslado->id_tecnico = $request->id_tecnico;
                $traslado->id_municipio = $request->id_municipio;
                $traslado->nueva_direccion = $request->nuevadirec;
                $traslado->observacion = $request->observacion;
                $traslado->update_direc = 0;
                $traslado->id_usuario=Auth::user()->id;
                $traslado->save();
                $this->setCorrelativo(7);
                
                //obteniendo el ultimo traslado
                $ultimo_traslado = Traslados::all()->last();
                $numero = $ultimo_traslado->numero;

                $obj_controller_bitacora=new BitacoraController();	
                $obj_controller_bitacora->create_mensaje('Traslado creado: '.$numero);
        
                flash()->success("Registro creado exitosamente!")->important();
               
                if($request->di==0){
        
                    return redirect()->route('traslados.index');
                }else{
                    return redirect()->route('cliente.traslados.index',$request->id_cliente);
                }
            }else
            {  
                flash()->error("Cliente No posee Tv activo!")->important();
                if($request->di==0){
        
                    return redirect()->route('traslados.create');
                }else{
                    return redirect()->route('cliente.traslados.create',$request->id_cliente);
                }
            }
        }  
       
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
        $id_cliente=0;
        return view("traslados.edit",compact('traslado','obj_tecnicos','obj_departamentos','id_cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $traslado=Traslados::where('id',$request->id_traslado)->get();
        if($request->tipo_servicio=="Internet")
        {   $cliente=Cliente::where('id',$traslado[0]->id_cliente)->where('internet','1')->get();
            $mensaje="Cliente no posee Internet activo!";
        }
        if($request->tipo_servicio=="Tv")
        {   $cliente=Cliente::where('id',$traslado[0]->id_cliente)->where('tv','1')->get();
            $mensaje="Cliente no posee Tv activo!";
           
        }    
        if(count($cliente)>0)
        {
            $fecha_trabajo=null;
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
        
        
            if($request->go_to==0){
    
                return redirect()->route('traslados.index');
            }else{
                return redirect()->route('cliente.traslados.index',$request->go_to);
            }
        }else
        {
            flash()->error($mensaje)->important();
            if($request->di==0){
    
                return redirect()->route('traslados.index');
            }else{
                return redirect()->route('cliente.traslados.index',$request->id_cliente);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id_cliente)
    {
        Traslados::destroy($id);
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Traslado eliminada con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        if($id_cliente==0){

            return redirect()->route('traslados.index');
        }else{
            return redirect()->route('cliente.traslados.index',$id_cliente);
        }
    }

    public function busqueda_cliente(Request $request){
        $term1 = $request->term;
        $results = array();
        
        $queries = Cliente::Where('codigo', 'LIKE', '%'.$term1.'%')->orWhere('nombre', 'LIKE', '%'.$term1.'%')->get();
        
        foreach ($queries as $query){
            $results[] = [ 'id' => $query->id, 'value' => "(".$query->codigo.") ".$query->nombre,'nombre' => $query->nombre];
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
    public function imprimir($id)
    {
        $traslado= Traslados::find($id);
        
        $velocidad="";
        $mac="";
        $marca="";
        $ip="";
        $dia_c="";
        if($traslado->tipo_servicio=="Internet")
        {
           
            if(Internet::where('id_cliente',$traslado->id_cliente)->where('activo','1')->count()>0)
            {   
                $i= Internet::where('id_cliente',$traslado->id_cliente)->where('activo','1')->get();
                $velocidad=$i[0]->velocidad;
                $mac=$i[0]->mac;
                $marca=$i[0]->marca;
                $ip=$i[0]->ip;
                $dia_c=$i[0]->dia_gene_fact;
            }
        }
        if($traslado->tipo_servicio=="Tv")
        {
           
            if( $tv=Tv::where('id_cliente',$traslado->id_cliente)->where('activo','1')->count()>0)
            {
                $tv=Tv::where('id_cliente',$traslado->id_cliente)->where('activo','1')->get();
                $dia_c=$tv[0]->dia_gene_fact;
            }
            
        }

        /*
        colilla roja=internet=1
        colilla verde=cable=2
        colilla amarilla=paquete=3
        */
        if($traslado->get_cliente->colilla=="1"){$colilla="Roja";}
        if($traslado->get_cliente->colilla=="2"){$colilla="Verde";}
        if($traslado->get_cliente->colilla=="3"){$colilla="Amarilla";}

        $fpdf = new FpdfClass('P','mm', 'Letter');
        
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('TRASLADO   | UNINET');

        $fpdf->SetXY(175,22);
        $fpdf->SetFont('Arial','',15);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(20,10,$traslado->numero);
        $fpdf->SetTextColor(0,0,0);
        $fpdf->SetFont('Arial','B',12);
        $fpdf->SetXY(83,35);
        $fpdf->cell(50,5,'ORDEN DE TRASLADO',0);
        $fpdf->SetXY(165,22);
        $fpdf->SetFont('Arial','',14);
        $fpdf->SetTextColor(194,8,8);
        $fpdf->Cell(30,10,utf8_decode('Nº.'));
        $fpdf->SetTextColor(0,0,0);


        $fpdf->SetFont('Arial','',11);
        $fpdf->SetXY(10,40);
        $fpdf->Cell(25,5,utf8_decode("Dia de cobro: "),0,0,'L');
        $fpdf->SetXY(35,40);
        $fpdf->Cell(10,5,utf8_decode($dia_c),'B',0,'L');
        $fpdf->SetXY(85,40);
        $fpdf->Cell(40,5,utf8_decode($traslado->get_cliente->nodo),0,0,'C');
        $fpdf->SetXY(165,40);
        $fpdf->Cell(40,5,utf8_decode($traslado->created_at),'B',0,'C');

        $fpdf->SetXY(10,50);
        $fpdf->Cell(15,5,utf8_decode("Código: "),0,0,'L');
        $fpdf->SetXY(25,50);
        $fpdf->Cell(15,5,utf8_decode($traslado->get_cliente->codigo),'B',0,'L');
        $fpdf->SetXY(60,50);
        $fpdf->Cell(20,5,utf8_decode("Nombre: "),0,0,'L');
        $fpdf->SetXY(80,50);
        $fpdf->Cell(85,5,utf8_decode($traslado->get_cliente->nombre),'B',0,'L');


        $fpdf->SetXY(10,56);
        $fpdf->Cell(30,5,utf8_decode("Suspendido en: "),0,1,'L');
        $fpdf->SetXY(40,56);
        $fpdf->MultiCell(165, 5, substr(utf8_decode($traslado->get_cliente->dirreccion_cobro),0,175), 'B', 'L');
        $fpdf->SetXY(10,70);
        $fpdf->Cell(40,5,utf8_decode("Dirección a trasladar: "),0,1,'L');
        $fpdf->SetXY(50,70);
        $fpdf->MultiCell(155, 5, substr(utf8_decode($traslado->nueva_direccion.' '.$traslado->get_municipio->nombre.' '.$traslado->get_municipio->get_departamento->nombre),0,175), 'B', 'L');
        
        /*$fpdf->SetXY(10,75);
        $fpdf->Cell(40,5,utf8_decode("Actividad a Realizar: "),0,0,'L');
        $fpdf->SetXY(50,75);
        $fpdf->Cell(50,5,utf8_decode($reconexion->get_actividad->actividad),'B',0,'L');*/
        $fpdf->SetXY(10,82);
        $fpdf->Cell(20,5,utf8_decode("Técnico: "),0,0,'L');
        $fpdf->SetXY(30,82);
        $fpdf->Cell(90,5,utf8_decode($traslado->get_tecnico->nombre),'B',0,'L');

        $fpdf->SetXY(10,89);
        $fpdf->Cell(20,5,utf8_decode("Télefono: "),0,0,'L');
        $fpdf->SetXY(30,89);
        $fpdf->Cell(40,5,utf8_decode($traslado->get_cliente->telefono1.'/'.$traslado->get_cliente->telefono2),'B',0,'L');
        $fpdf->SetXY(73,89);
        $fpdf->Cell(12,5,utf8_decode("Colilla:"),0,0,'L');
        $fpdf->SetXY(85,89);
        $fpdf->Cell(20,5,utf8_decode($colilla),'B',0,'L');
        $fpdf->SetXY(107,89);
        $fpdf->Cell(25,5,utf8_decode("Coordenadas:"),0,0,'L');
        $fpdf->SetXY(132,89);
        $fpdf->Cell(35,5,utf8_decode($traslado->get_cliente->cordenada),'B',0,'L');


        $fpdf->SetXY(10,96);
        $fpdf->Cell(40,5,utf8_decode("Observaciones:"),0,0,'L');
        $fpdf->SetXY(40,96);
        $fpdf->MultiCell(165, 5, substr(utf8_decode($traslado->observacion),0,255), 'B', 'L');
        
        $fpdf->SetXY(10,115);
        $fpdf->Cell(30,5,utf8_decode("Fecha realizado:"),0,0,'L');
        $fpdf->SetXY(40,115);
        if($traslado->fecha_trabajo!=''){$fpdf->Cell(30,5,utf8_decode($traslado->fecha_trabajo->format('d/m/Y')),'B',0,'L');}
        else{$fpdf->Cell(30,5,' / / ','B',0,'L');}
        $fpdf->SetXY(70,115);
        $fpdf->Cell(30,5,utf8_decode("Servicio:".$traslado->tipo_servicio),0,0,'L');

        $fpdf->SetXY(10,125);
        $fpdf->Cell(40,5,utf8_decode("_________________"),0,0,'L');
        $fpdf->SetXY(90,125);
        $fpdf->Cell(40,5,utf8_decode("_________________"),0,0,'L');
        $fpdf->SetXY(165,125);
        $fpdf->Cell(40,5,utf8_decode("_________________"),0,0,'L');
        $fpdf->SetXY(10,130);
        $fpdf->Cell(40,5,utf8_decode("Cliente"),0,0,'C');
        $fpdf->SetXY(90,130);
        $fpdf->Cell(40,5,utf8_decode("Técnico"),0,0,'C');
        $fpdf->SetXY(165,130);
        $fpdf->Cell(40,5,utf8_decode("Autorizado"),0,0,'C');
        $fpdf->SetXY(10,135);
        $fpdf->Cell(40,5,utf8_decode("Creado por: ".Auth::user()->name),0,0,'L');
        $fpdf->Line(10,140,205,140,225,140);
  
        $fpdf->Output();
        exit;

    }
    public function update_direc($id_traslado,$id_cliente)
    {
        $traslado = Traslados::find($id_traslado);
        Cliente::where('id',$traslado->id_cliente)->update([
            'dirreccion'=>$traslado->nueva_direccion,
            'id_municipio'=>$traslado->id_municipio
            ]);
        Traslados::where('id',$id_traslado)->update(['update_direc' =>'1']);
        flash()->success("Registro editado exitosamente!")->important();
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Cliente editada con el id: '. $traslado->id_cliente);
        if($id_cliente==0){

            return redirect()->route('traslados.index');
        }else{
            return redirect()->route('cliente.traslados.index',$id_cliente);
        }
         
    }
}
