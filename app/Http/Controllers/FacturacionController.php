<?php

namespace App\Http\Controllers;
use App\Models\Cobrador;
use App\Models\Correlativo;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use App\Models\Abono;
use App\Models\Factura;
use App\Models\Factura_detalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Luecano\NumeroALetras\NumeroALetras;
use App\Models\Producto;
use App\Fpdf\FpdfFactura;

class FacturacionController extends Controller
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
        $obj_cobrador = Cobrador::all();
        return view('facturacion/index', compact('obj_cobrador'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "hello";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$cuota)
    {
        $results = array();
        $xdatos['cliente']='';
        $xdatos['correlativo']='';
        $xdatos['tipo_docu']='';
        $xdatos['fecha']='';
        $xdatos['iva']='';
        $xdatos['sumas']='';
        $xdatos['total']='';
        $xdatos['results']=[];
        if($cuota==0){
            $factura=Factura::find($id);
            $detalle=Factura_detalle::where('id_factura',$id)->get();
            if($detalle->count()>0)
            {
                foreach ($detalle as $query){
                    $results[] = [ 'cantidad' => $query->cantidad, 'producto' => $query->get_producto->nombre,'precio' => number_format($query->precio,2),'subtotal'=> number_format($query->subtotal,2)];
                }
                $xdatos['results']=$results;
            }
            if($factura->tipo_documento==1){
                $tipo='FAC';
            }else{
                $tipo='CRE';
            }
    
            $xdatos['cliente']=$factura->get_cliente->nombre;
            $xdatos['correlativo']=$tipo."_".$factura->numero_documento;
            $xdatos['fecha']=$factura->created_at->format('d/m/Y');
            $xdatos['tipo_docu']=$factura->tipo_documento;
            $xdatos['iva']=number_format($factura->iva,2);
            $xdatos['sumas']=number_format($factura->sumas,2);
            $xdatos['total']=number_format($factura->total,2);
            if(!isset($factura->get_cliente->get_municipio->nombre)){
                $municipio="Imcompleto";
                
            }else{$municipio=$factura->get_cliente->get_municipio->nombre;}
            if(!isset($factura->get_cliente->get_municipio->get_departamento->nombre)){
                $departamento="Imcompleto";
            }else{$departamento=$factura->get_cliente->get_municipio->get_departamento->nombre;}
            $xdatos['direccion']=$factura->get_cliente->dirreccion.' '. strtoupper($municipio).' '.strtoupper($departamento);
            return $xdatos;
        }else{
            $factura=Factura::find($id);
            $detalle=Abono::where('id_factura',$id)->where('cargo','0.00')->get();
            if($detalle->count()>0)
            {
                foreach ($detalle as $query){
                    if($query->tipo_servicio==1){
                        $servicio="Internet";
                    }else{
                        $servicio="Television";
                    }
                    $results[] = [ 'cantidad' => '1', 'producto' => $servicio,'precio' => number_format($query->abono,2),'subtotal' => number_format($query->abono,2)];
                }
                $xdatos['results']=$results;
            }else{
                
            }
            if($factura->tipo_documento==1){
                $tipo='FAC';
            }else{
                $tipo='CRE';
            }
    
            $xdatos['cliente']=$factura->get_cliente->nombre;
            $xdatos['correlativo']=$tipo."_".$factura->numero_documento;
            $xdatos['fecha']=$factura->created_at->format('d/m/Y');
            $xdatos['tipo_docu']=$factura->tipo_documento;
            $xdatos['iva']=number_format($factura->iva,2);
            $xdatos['sumas']=number_format($factura->sumas,2);
            $xdatos['total']=number_format($factura->total,2);
            if(!isset($factura->get_cliente->get_municipio->nombre)){
                $municipio="Imcompleto";
                
            }else{$municipio=$factura->get_cliente->get_municipio->nombre;}
            if(!isset($factura->get_cliente->get_municipio->get_departamento->nombre)){
                $departamento="Imcompleto";
            }else{$departamento=$factura->get_cliente->get_municipio->get_departamento->nombre;}
            $xdatos['direccion']=$factura->get_cliente->dirreccion.' '. strtoupper($municipio).' '.strtoupper($departamento);
            return $xdatos;   
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$cuota)
    {   $factura = Factura::find($id);
        Factura::destroy($id);
        if($cuota==1)
        {
            Abono::where('id_factura', $id)->delete();
        }else{
            Factura_detalle::where('id_factura', $id)->delete();
        }
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Se elimino '.$factura->tipo.': '.$factura->numero_documento);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('facturacion.gestion');
    }

    public function anular($id)
    {
        Factura::where('id',$id)->update(['anulada' =>1]);
        $factura = Factura::find($id);
        Abono::where('id_factura',$id)->where('cargo',0.00)->update(['anulado' =>1]);
        //Abono::where('id_factura',$id)->where('abono',0.00)->update(['pagado'=>0]);
        $abono=Abono::where('id_factura',$id)->where('cargo','0.00')->get();
        foreach($abono as $row)
        {
            Abono::where('id_cliente',$factura->id_cliente)->where('mes_servicio',$row->mes_servicio)->where('abono','0.00')->where('tipo_servicio',$row->tipo_servicio)->update(['pagado' =>0]);
        }
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Se anulo '.$factura->tipo.': '.$factura->numero_documento);

        flash()->success("Factura anulada exitosamente!")->important();
        return redirect()->route('facturacion.gestion');
    }

    // Autocomplete de Cliente
    public function busqueda_cliente(Request $request){
        $term1 = $request->term;
        $results = array();
        $queries = Cliente::
        where('activo','1')->
        Where('codigo', 'LIKE', '%'.$term1.'%')->
        orWhere('nombre', 'LIKE', '%'.$term1.'%')->
        Where('id_sucursal',Auth::user()->id_sucursal)->
        get();    
        foreach ($queries as $query){
            $results[] = [ 'id' => $query->id, 'value' => "(".$query->codigo.") ".$query->nombre,'nombre' => $query->nombre,'tipo_documento'=>$query->tipo_documento,'direc'=>$query->dirreccion,'nit'=>$query->nit];
        }
        return response($results);       
    
    }   
    public function cargo($id_cliente,$servicio)
    {   $results = array();
        $xdatos['typeinfo']='';
        $xdatos['msg']='';
        $xdatos['results']=[];
        if($servicio==2 || $servicio==1)
        {
            if($servicio==1)//1=internet
            {
                $servi=Cliente::where('id',$id_cliente)->where('internet','1')->count();
                $mensaje="Cliente no posee Internet activo!";
                $abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->where('pagado','0')->where('tipo_servicio',1)->get();
    
            }
            if($servicio==2)//2=television
            {
                $servi=Cliente::where('id',$id_cliente)->where('tv','1')->count();
                $mensaje="Cliente no posee Tv activo!";
                $abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->where('pagado','0')->where('tipo_servicio',2)->get();
    
            }
            if($servi>0)
            {   
                if($abono->count()>0)
                {
                    foreach ($abono as $query){
                        $cargo_sin_iva=$query->cargo/1.13;
                        $results[] = [ 'id' => $query->id, 'cargo' => $query->cargo,'mes_servicio' => $query->mes_servicio->format('m/Y'),'fecha_vence'=>$query->fecha_vence->format('d/m/Y'),'mes_ser'=>$query->mes_servicio->format('Y/m/d'),'cargo_sin_iva'=>$cargo_sin_iva];
                    }
                    $xdatos['typeinfo']='Success';
                    $xdatos['results']=$results;
                }else
                {
                    $xdatos['typeinfo']='Warning';
                    $xdatos['msg']='Cliente no posee cargos generados';
                    
                }
           
              return response($xdatos);   
               /*$abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->get();
                return response()->json(
                    $abono-> toArray()  
                );*/
            }else
            {   
                $xdatos['typeinfo']='Warning';
                $xdatos['msg']=$mensaje;
                $xdatos['cabtidad']=0;
                return $xdatos;
            
            }
        }else
        {
            return "El servicio es requerido";
        }
    }
    public function total_texto($total)
    {
      $formatter = new NumeroALetras();
      $letras = $formatter->toInvoice($total, 2, 'DOLARES');
      
      //Asi envias la respuesta
      return response()->json([
          'letras' => $letras,
      ]);
    }
    public function guardar(Request $request)//SE GUARDA FACTURA Y ABONO
    {   
        if ($request->cuantos >0)
        { 
            if(Factura::where('tipo_documento',$request->tipo_impresion)->where('numero_documento',$request->numdoc)->exists())
            {
                
                $xdatos['typeinfo']='Warning';
                $xdatos['msg']='el número de documento ya fue impreso.';
                return response($xdatos);
            }else
            { 
                if($request->tipo_impresion==1){$tipo="FACTURA";}
                if($request->tipo_impresion==2){$tipo="CREDITO FISCAL";}
                $factura = new Factura();
                $factura->id_usuario=Auth::user()->id;
                $factura->id_cliente=$request->id_cliente;
                $factura->id_cobrador=$request->id_cobrador;
                $factura->sumas=$request->sumas;
                $factura->iva=$request->iva;
                $factura->subtotal=$request->subtotal;
                $factura->suma_gravada=$request->suma_gravada;
                $factura->venta_exenta=$request->venta_exenta;
                $factura->total=$request->total;
                $factura->tipo_pago=$request->tipo_pago;
                $factura->tipo=$tipo;
                $correlativo=Correlativo::find($request->tipo_impresion);
                $factura->serie=$correlativo->serie;
                $factura->tipo_documento=$request->tipo_impresion;
                $factura->numero_documento=$request->numdoc;
                $factura->impresa=0;
                $factura->cuota=1;
                $factura->tipo_servicio=$request->tipo_servicio;
                $factura->anulada=0;
                $factura->id_sucursal=Auth::user()->id_sucursal;
                $factura->save();
                $ultima_factura = Factura::all()->last();
                $id_factura =$ultima_factura->id;
                if($factura)
                {  
                    //comienza lo de abonos
                    $array = json_decode($request->json_arr, true);
                    foreach ($array as $fila)
                    {   
                        if($request->tipo_impresion==1){$tipo="FAC";}
                        if($request->tipo_impresion==2){$tipo="CRE";}
                        $abono = new Abono();
                        $abono->id_factura=$id_factura;
                        $abono->id_cliente=$request->id_cliente;
                        $abono->id_cobrador=$request->id_cobrador;
                        $abono->id_usuario=Auth::user()->id;
                        $abono->recibo = $request->numreci;
                        $abono->tipo_servicio=$request->tipo_servicio;
                        $abono->numero_documento=$tipo."-".$request->numdoc;
                        $abono->tipo_documento=$request->tipo_impresion;
                        $abono->tipo_pago=$request->tipo_pago;
                        $abono->mes_servicio=$fila['mes_ser'];
                        $abono->fecha_aplicado=date('Y/m/d');
                        $abono->fecha_vence=Carbon::createFromFormat('d/m/Y', $fila['fecha_ven']);
                        $abono->cargo=0;
                        if($request->exenta==0){
                            $abono->abono=$fila['cuota'];
                            $abono->exento=0;
                         
                        }else{
                            $abono->abono=$fila['precio'];
                            $abono->exento=1;
                            
                        }
                        $abono->precio=$fila['precio'];
                        $abono->anulado=0;
                        $abono->pagado=1;
                        $abono->save();
                        if($abono)
                        {
                            if($fila['id']!=0)
                            {   //se pone que se pago el cargo y se le asigna el id factura al cargo
                                Abono::where('id',$fila['id'])->update(['pagado' =>'1']);
                                Abono::where('id',$fila['id'])->update(['id_factura' =>$id_factura]);
                            }
                        }
                    }
                    Cobrador::where('id',$request->id_cobrador)->update(['recibo_ultimo' =>$request->numreci]);
                    $this->setCorrelativo($request->tipo_impresion);
                    //obteniendo la ultima factura
                    $ultimo_factura = Factura::all()->last();
                    $numero_docu = $ultimo_factura->numero_documento;
                    $tipo_docu = $ultimo_factura->tipo;

                    $obj_controller_bitacora=new BitacoraController();	
                    $obj_controller_bitacora->create_mensaje('Se creo '.$tipo_docu.': '.$numero_docu);

                    $xdatos['typeinfo']='Success';
                    $xdatos['id_factura']=$id_factura;
                    $xdatos['msg']='Guardado con exito.';
                    //$xdatos['results']=$results2;
                    return response($xdatos);
                }else
                {
                    $xdatos['typeinfo']='Warning';
                    $xdatos['msg']='no se puedo guardar la factura.';
                    return response($xdatos);
                }
            }
            
        }else{
            $xdatos['typeinfo']='Warning';
            $xdatos['msg']="No hay abonos para ingresar.";
            return response($xdatos);
        }
    }

    public function correlativo($id){// estaa como private


        $correlativo = Correlativo::find($id);
        $ultimo = $correlativo->ultimo+1;

        return $this->get_correlativo($ultimo,6);

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

    public function num_recibo($id_cobrador)
    {
    
       $correlativo = Cobrador::find($id_cobrador);
        $ultimo = $correlativo->recibo_ultimo+1;

        return $this->get_correlativo($ultimo,5);
    }
    
    public function ultimo_mes($id_cliente, $tipo_ser,$filas)
    {   /*nota:segun la logica por lo menos debe tener un abono realizado para ver el ultimo mes
        y asi para los que siguen, si tiene cuotas pendientes no quitaras y usar el boton anticipo de meses*/ 
        //1=internet y 2=television
        $xdatos['typeinfo']='';
        $xdatos['msg']='';
        $xdatos['results']=[];
        if($tipo_ser==1){$contrato= Internet::select('cuota_mensual','fecha_primer_fact')->where('id_cliente',$id_cliente)->where('activo','1')->get(); }
        if($tipo_ser==2){$contrato= Tv::select('cuota_mensual','fecha_primer_fact')->where('id_cliente',$id_cliente)->where('activo','1')->get(); }
        $results2 = array();
        if(count($contrato)!=0)
        {
            $precio=$contrato[0]->cuota_mensual;
            $abono= Abono::where('id_cliente',$id_cliente)->where('tipo_servicio',$tipo_ser)->where('cargo','0.00')->where('pagado','1')->where('anulado','0')->get();
            $abono1=$abono->last();
            $results2 = array();           
            if($filas==0)//valida si la tabla no tiene ningun mes a pagar
            {
                if($abono->count()>0)
                {
                    $mes_servicio=date("d-m-Y", strtotime($abono1->mes_servicio."+ 1 month"));
                    $mes_ser=date("Y/m/d", strtotime($abono1->mes_servicio."+ 1 month"));
                    $fecha_ven=date("d-m-Y", strtotime($mes_servicio."+ 1 month"));
                    $fecha_vence=date("d/m/Y", strtotime($fecha_ven."+ 10 days"));
                    $cargo_sin_iva=$precio/1.13;
                    $mes=explode("-", $mes_servicio);
                    $results2[] = [ 
                        'id' => $abono1->id,
                        'cargo' => $precio,
                        'mes_servicio' =>$mes[1].'/'.$mes[2],
                        'fecha_vence'=>$fecha_vence,
                        'mes_ser'=>$mes_ser,
                        'cargo_sin_iva'=>$cargo_sin_iva,
                    ];
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='ok';
                    $xdatos['results']=$results2;
                    return response($xdatos);
                }else
                {
                    $mes_servicio=date("d-m-Y", strtotime($contrato[0]->fecha_primer_fact."- 1 month"));
                    $mes_ser=date("Y/m/d", strtotime($contrato[0]->fecha_primer_fact."- 1 month"));
                    $fecha_ven=date("d-m-Y", strtotime($mes_servicio."+ 1 month"));
                    $fecha_vence=date("d/m/Y", strtotime($contrato[0]->fecha_primer_fact."+ 10 days"));
                    $cargo_sin_iva=$precio/1.13;
                    $mes=explode("-", $mes_servicio);
                    $results2[] = [ 
                        //'id' => $abono1->id,
                        'cargo' => $precio,
                        'mes_servicio' =>$mes[1].'/'.$mes[2],
                        'fecha_vence'=>$fecha_vence,
                        'mes_ser'=>$mes_ser,
                        'cargo_sin_iva'=>$cargo_sin_iva,
                    ];
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='ok';
                    $xdatos['results']=$results2;
                    return response($xdatos);    
                }        
            }
            if($filas>0)// validad si la tabla tienes meses a pagar
            {   
                if($abono->count()>0)
                {
                    $filas =$filas+1;
                    $mes_servicio=date("d-m-Y", strtotime($abono1->mes_servicio."+ ".$filas." month"));
                    $mes_ser=date("Y/m/d", strtotime($abono1->mes_servicio."+ ".$filas." month"));
                    $fecha_ven=date("d-m-Y", strtotime($mes_servicio."+ 1 month"));
                    $fecha_vence=date("d/m/Y", strtotime($fecha_ven."+ 10 days"));
                    $cargo_sin_iva=$precio/1.13;
                    $mes=explode("-", $mes_servicio);
                    $results2[] = [ 
                        'id' => $abono1->id,
                        'cargo' => $precio,
                        'mes_servicio' =>$mes[1].'/'.$mes[2],
                        'fecha_vence'=>$fecha_vence,
                        'mes_ser'=>$mes_ser,
                        'cargo_sin_iva'=>$cargo_sin_iva,
                    ];
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='ok';
                    $xdatos['results']=$results2;
                    return response($xdatos);
                }else
                {
                    $filas =$filas-1;
                    $mes_servicio=date("d-m-Y", strtotime($contrato[0]->fecha_primer_fact."+ ".$filas." month"));
                    $mes_ser=date("Y/m/d", strtotime($contrato[0]->fecha_primer_fact."+ ".$filas." month"));
                    $fecha_ven=date("d-m-Y", strtotime($mes_servicio."+ 1 month"));
                    $fecha_vence=date("d/m/Y", strtotime($fecha_ven."+ 10 days"));
                    $cargo_sin_iva=$precio/1.13;
                    $mes=explode("-", $mes_servicio);
                    $show_mes=strtotime($contrato[0]->fecha_primer_fact);
                    $results2[] = [ 
                        //'id' => $abono1->id,
                        'cargo' => $precio,
                        'mes_servicio' =>$mes[1].'/'.$mes[2],
                        'fecha_vence'=>$fecha_vence,
                        'mes_ser'=>$mes_ser,
                        'cargo_sin_iva'=>$cargo_sin_iva,
                    ];
                    $xdatos['typeinfo']='Success';
                    $xdatos['msg']='ok';
                    $xdatos['results']=$results2;
                    return response($xdatos);
                }
            }

        }else
        {
            $xdatos['typeinfo']='Warning';
            $xdatos['msg']='Cliente no posee servicio Activo.';
            $xdatos['results']=$results2;
            return response($xdatos);
        }

    }

    //------------COMIENZA LAS FUNCIONES DE LA FACTURA MANUAL
    public function index2()
    {
        $obj_cobrador = Cobrador::all();
        return view('facturacion/index2', compact('obj_cobrador'));


    }
    public function busqueda_producto(Request $request){
        $term1 = $request->term;
        $results = array();
        $queries = Producto::
        Where('nombre', 'LIKE', '%'.$term1.'%')->
        Where('id_sucursal',Auth::user()->id_sucursal)->
        get();    
        foreach ($queries as $query){
            $precio_sin_iva=$query->precio/1.13;
            $results[] = [ 'id' => $query->id, 'value' => $query->nombre,'nombre' => $query->nombre,'precio'=>$query->precio,'precio_sin_iva'=>$precio_sin_iva,'exento'=>$query->exento];
        }
        return response($results);       
    
    }
    public function venta(Request $request){
        $xdatos['typeinfo']='';
        $xdatos['msg']='';
        $xdatos['results']=[];
        if ($request->cuantos >0)
        { 
            if(Factura::where('tipo_documento',$request->tipo_impresion)->where('numero_documento',$request->numdoc)->exists())
            {
                
                $xdatos['typeinfo']='Warning';
                $xdatos['msg']='Este numero de documento ya fue impresa.';
                return response($xdatos);
            }else
            { 
                if($request->tipo_impresion==1){$tipo="FACTURA";}
                if($request->tipo_impresion==2){$tipo="CREDITO FISCAL";}
                $factura = new Factura();
                $factura->id_usuario=Auth::user()->id;
                $factura->id_cliente=$request->id_cliente;
                $factura->id_cobrador=$request->id_cobrador;
                $factura->sumas=$request->sumas;
                $factura->iva=$request->iva;
                $factura->subtotal=$request->subtotal;
                $factura->suma_gravada=$request->suma_gravada;
                $factura->venta_exenta=$request->venta_exenta;
                $factura->total=$request->total;
                $factura->tipo_pago=$request->tipo_pago;
                $factura->tipo=$tipo;
                $correlativo=Correlativo::find($request->tipo_impresion);
                $factura->serie=$correlativo->serie;
                $factura->tipo_documento=$request->tipo_impresion;
                $factura->numero_documento=$request->numdoc;
                $factura->impresa=0;
                $factura->cuota=0;
                $factura->tipo_servicio=0;
                $factura->anulada=0;
                $factura->id_sucursal=Auth::user()->id_sucursal;
                $factura->save();
                $ultima_factura = Factura::all()->last();
                $id_factura =$ultima_factura->id;
                if($factura)
                {  
                    //comienza factura detalle
                    $array = json_decode($request->json_arr, true);
                    foreach ($array as $fila)
                    {   
                        //if($request->tipo_impresion==1){$tipo="FAC";}
                        //if($request->tipo_impresion==2){$tipo="CRE";}
                        $Fdetalle = new Factura_detalle();
                        $Fdetalle->id_factura=$id_factura;
                        $Fdetalle->id_producto=$fila['id'];
                        $Fdetalle->cantidad=$fila['cantidad'];
                        if($request->tipo_impresion==1){
                            $Fdetalle->precio=$fila['precio_venta'];
                        }
                        if($request->tipo_impresion==2){
                            $Fdetalle->precio=$fila['precio_sin_iva'];
                        }
                        $Fdetalle->subtotal = $fila['subtotal'];
                        $Fdetalle->save();
                    }
                    //Cobrador::where('id',$request->id_cobrador)->update(['recibo_ultimo' =>$request->numreci]);
                    $this->setCorrelativo($request->tipo_impresion);
                    
                    //obteniendo la ultima factura
                    $ultimo_factura = Factura::all()->last();
                    $numero_docu = $ultimo_factura->numero_documento;
                    $tipo_docu = $ultimo_factura->tipo;

                    $obj_controller_bitacora=new BitacoraController();	
                    $obj_controller_bitacora->create_mensaje('Se creo '.$tipo_docu.': '.$numero_docu);

                    $xdatos['typeinfo']='Success';
                    $xdatos['id_factura']=$id_factura;
                    $xdatos['msg']='Guardado con exito.';
                    return response($xdatos);
                }else
                {
                    $xdatos['typeinfo']='Error';
                    $xdatos['msg']='no se puedo guardar la factura.';
                    return response($xdatos);
                }
            }
            
        }else{
            
            $xdatos['typeinfo']='Error';
            $xdatos['msg']='No hay productos en la venta.';
            return response($xdatos);
            
        }   
    }
    //GESTION FACTURAS MANUALES
    public function index3()
    {
        $obj_factura = Factura::where('id_sucursal',Auth::user()->id_sucursal)->get();
        return view('facturacion/index3');
    }
    public function imprimir_factura($id,$efectivo,$cambio){
        $factura = Factura::find($id);
        $tipo_pago="";
        if($factura->tipo_pago=='EFEC'){
            $tipo_pago = 'EFECTIVO';
        }
        if($factura->tipo_pago=='BITCOIN'){
            $tipo_pago = 'BITCOIN';
        }
        if($factura->tipo_pago=='DEPO'){
            $tipo_pago = 'DEPOSITO';
        }
        if($factura->tipo_pago=='TRANS'){
            $tipo_pago = 'TRANSFERENCIA';
        }
        if($factura->tipo_pago=='POST'){
            $tipo_pago = 'POST';
        }

        if($factura->tipo_documento==1){//imprimo factura
            
            $fpdf = new FpdfFactura('P','mm', array(155,240));
            $fpdf->AddFont('Arial','','ARIAL.php');
            $fpdf->AliasNbPages();
            $fpdf->AddPage();
            $fpdf->SetTitle('FACTURA FINAL | UNINET');

            $fpdf->SetXY(125,18);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('No. '.$factura->numero_documento));
    
            $fpdf->SetXY(118,35);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode(date('d/m/Y')));
    
            $fpdf->SetXY(22,42);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->nombre));
    
            $fpdf->SetXY(25,48);
            $direccion = substr($factura->get_cliente->dirreccion,0,50);
            $fpdf->SetFont('Arial','',9);
            $fpdf->Cell(20,10,utf8_decode($direccion));
    
    
            $fpdf->SetXY(26,55);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->dui));
    
            $fpdf->SetXY(42,62);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->telefono1));
    
            $fpdf->SetFont('Arial','',10);

            $formatter = new NumeroALetras();

            $letras = $formatter->toInvoice($factura->total, 2, 'DOLARES');

            $fpdf->SetXY(16,160);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($letras));

            $fpdf->SetXY(18,154);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('TIPO DE PAGO: '.$tipo_pago));


            $fpdf->SetXY(134,161);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->sumas,2)));


            $fpdf->SetXY(134,197);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->total,2)));
           
            $y=83;
        }

        if($factura->tipo_documento==2){
            
            $fpdf = new FpdfFactura('P','mm', array(163,240));
            $fpdf->AddFont('Arial','','ARIAL.php');

            $detalle_factura = Abono::where('id_factura',$id)->get();
            $fpdf->AliasNbPages();
            $fpdf->AddPage();
            $fpdf->SetTitle('FACTURA CREDITO| UNINET');

            $fpdf->SetXY(125,20);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('No. '.$factura->numero_documento));
        
            $fpdf->SetXY(115,47);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode(date('d/m/Y')));
        
            $fpdf->SetXY(115,51);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->numero_registro));
        
            $fpdf->SetXY(115,58);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->nit));
        
            $fpdf->SetXY(115,68);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->giro));
        
            $fpdf->SetXY(20,47);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->nombre));
        
            $fpdf->SetXY(23,57);
            $direccion = substr($factura->get_cliente->dirreccion,0,45);
            $fpdf->SetFont('Arial','',9);
            $fpdf->Cell(20,10,utf8_decode($direccion));
        
            
            $fpdf->SetXY(23,62);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->get_municipio->nombre));
        
            $fpdf->SetXY(65,62);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->get_municipio->get_departamento->nombre));
        
        
            $fpdf->SetFont('Arial','',10);

            
            $formatter = new NumeroALetras();
            $letras = $formatter->toInvoice($factura->total, 2, 'DOLARES');

            $fpdf->SetXY(16,161);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode($letras));

            $fpdf->SetXY(16,167);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('TIPO DE PAGO: '.$tipo_pago));


            $fpdf->SetXY(131,156);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->sumas,2)));

            $fpdf->SetXY(131,164);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->iva,2)));

            $fpdf->SetXY(131,172);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->total,2)));

            //$fpdf->SetXY(131,184);
            //$fpdf->SetFont('Arial','',10);
            //$fpdf->Cell(20,10,utf8_decode('$ '.number_format(0,2)));


            $fpdf->SetXY(131,201);
            $fpdf->SetFont('Arial','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->total,2)));
           
            $y=92;
        }
        if($factura->cuota==1){

            $detalle_factura = Abono::where('id_factura',$id)->where('cargo',0.00)->get();

            foreach ($detalle_factura as $value) {
                if($value->tipo_servicio==1){
                    $internet = Internet::where('id_cliente',$value->id_cliente)->where('activo',1)->get();
                    //$fecha_i=$internet->dia_gene_fact.''.date('/m/Y');
                    $concepto = "SERVICIO DE INTERNET ".$internet[0]->velocidad;
                    $concepto1 = 'DESDE '.$value->mes_servicio->format('d/m/Y')." HASTA ".date("d/m/Y",strtotime($value->mes_servicio."+ 1 month"));
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode(1));
                    $fpdf->SetXY(20,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto));
                    $y+=5;
                    $fpdf->SetXY(20,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto1));
                    $y-=3;
                    $fpdf->SetXY(134,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    $y+=10;
    
                }else{
                    $tv = Tv::where('id_cliente',$value->id_cliente)->where('activo',1)->get();
                    $concepto = "SERVICIO DE TELEVISIÓN";
                    $concepto1 = 'DESDE '.$value->mes_servicio->format('d/m/Y')." HASTA ".date("d/m/Y",strtotime($value->mes_servicio."+ 1 month"));
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode(1));
                    $fpdf->SetXY(20,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto));
                    $y+=5;
                    $fpdf->SetXY(20,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto1));
                    $y-=3;
                    $fpdf->SetXY(134,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    $y+=14;
    
                }
               
               
            }
        }else{

            $detalle_factura = Factura_detalle::where('id_factura',$id)->get();

            foreach ($detalle_factura as $value) {
                if($value->tipo_servicio==1){
                   
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->cantidad));
                    $fpdf->SetXY(20,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->get_producto->nombre));
                    //agregar subtotal despues de precio unitario
                    $fpdf->SetXY(95,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    $fpdf->SetXY(134,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->subtotal,2)));
                    $y+=5;
    
                }else{
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->cantidad));
                    $fpdf->SetXY(20,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->get_producto->nombre));

                    //agregar subtotal despues de precio unitario
                    $fpdf->SetXY(95,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    
                    $fpdf->SetXY(134,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->subtotal,2)));
                    //agregar subtotal despues de precio unitario
                    $y+=7;
    
                }
               
               
            }


        }
        $fpdf->Output();
        exit;
    }
    //datos para la gestion de facturas
    public function getFacturas(Request $request){
        
        $columns = array( 
            0 =>'id',
            1 =>'numero_documento',
            2 =>'cliente',
            3 => 'id_cobrador',
            4 => 'total'
            //5=> 'fecha',
           // 6=> 'tipo',
            //7=> 'estado',
            //8=> 'id'
        );

        $totalData = Factura::where('id_sucursal',Auth::user()->id_sucursal)->count();

        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {   
            $posts = Factura::select(
                'clientes.codigo',
                'clientes.nombre',
                'facturas.id',
                'facturas.total',
                'facturas.tipo_documento',
                'facturas.numero_documento',
                'facturas.cuota',
                'facturas.anulada',
                'facturas.created_at',
                'cobradors.nombre as nombre_cobrador',
            )
             ->join('clientes','facturas.id_cliente','=','clientes.id')
             ->join('cobradors','facturas.id_cobrador','=','cobradors.id')
             ->where('facturas.id_sucursal',Auth::user()->id_sucursal)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }else{
            $search = $request->input('search.value');
            $posts =  Factura::select(
                'clientes.codigo',
                'clientes.nombre',
                'facturas.id',
                'facturas.total',
                'facturas.tipo_documento',
                'facturas.numero_documento',
                'facturas.cuota',
                'facturas.anulada',
                'facturas.created_at',
                'cobradors.nombre as nombre_cobrador',
            )
            ->join('clientes','facturas.id_cliente','=','clientes.id')
            ->join('cobradors','facturas.id_cobrador','=','cobradors.id')
            ->orwhere('facturas.numero_documento','LIKE',"%{$search}%")
            ->orWhere('clientes.nombre', 'LIKE',"%{$search}%")
            ->orwhere('cobradors.nombre','LIKE',"%{$search}%")
            ->where('facturas.id_sucursal',Auth::user()->id_sucursal)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = Factura::select(
                'clientes.codigo',
                'clientes.nombre',
                'facturas.id',
                'facturas.total',
                'facturas.tipo_documento',
                'facturas.numero_documento',
                'facturas.cuota',
                'facturas.anulada',
                'facturas.created_at',
                'cobradors.nombre as nombre_cobrador',
            )
            ->join('clientes','facturas.id_cliente','=','clientes.id')
            ->join('cobradors','facturas.id_cobrador','=','cobradors.id')
            ->orwhere('facturas.numero_documento','LIKE',"%{$search}%")
            ->orWhere('clientes.nombre', 'LIKE',"%{$search}%")
            ->orwhere('cobradors.nombre','LIKE',"%{$search}%")
            ->where('facturas.id_sucursal',Auth::user()->id_sucursal)
            ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $tipo_doc=$post->tipo_documento;
                if($tipo_doc==1){
                    $nestedData['numero_documento'] = 'FAC_'.$post->numero_documento;
                }else{
                    $nestedData['numero_documento'] = 'CRE_'.$post->numero_documento;

                }
                $nestedData['cliente'] = $post->nombre;
                $nestedData['cobrador'] = $post->nombre_cobrador;
                $nestedData['total'] = '$'.$post->total;
                $nestedData['fecha'] = $post->created_at->format('d-m-Y');
                if($post->cuota==1){
                    $tipo="<div class='col-md-8 badge badge-pill badge-primary'>Cuota </div>";
                }else{
                    $tipo="<div class='col-md-8 badge badge-pill badge-secondary'>Manual</div>";
                }
                $nestedData['tipo'] = $tipo;
                if($post->anulada==0){
                    $estado="<div class='col-md-8 badge badge-pill badge-success'>Finalizada</div>";
                }else{
                    $estado="<div class='col-md-8 badge badge-pill badge-danger'>Anulada</div>";
                }
                $nestedData['estado'] = $estado;
                $actionBtn = '<div class="btn-group mr-1 mt-2">
                <button type="button" class="btn btn-primary">Acciones</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-chevron-down"></i>
                </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="detalleFactura('.$post->id.','.$post->cuota.')">Ver Factura</a>
                        <a class="dropdown-item" href="#" onclick="imprimir('.$post->id.')">Imprimir</a>
                        <a class="dropdown-item" href="#" onclick="anular('.$post->id.')">Anular</a>
                        <a class="dropdown-item" href="#" onclick="eliminar('.$post->id.','.$post->cuota.')">Eliminar</a>
                        <div class="dropdown-divider"></div>
                    
                    </div>
                </div>';
                $nestedData['action']=$actionBtn;

                //$nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                //$nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                //                    &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );

        echo json_encode($json_data);
        /*echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
        );*/
    }

}
