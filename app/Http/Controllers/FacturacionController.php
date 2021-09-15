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
                    $results[] = [ 'cantidad' => $query->cantidad, 'producto' => $query->get_producto->nombre,'precio' => $query->precio,'subtotal'=>$query->subtotal];
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
            $xdatos['iva']=$factura->iva;
            $xdatos['sumas']=$factura->sumas;
            $xdatos['total']=$factura->total;
            $xdatos['direccion']=$factura->get_cliente->dirreccion.' '. strtoupper($factura->get_cliente->get_municipio->nombre).' '.strtoupper($factura->get_cliente->get_municipio->get_departamento->nombre);
            return $xdatos;
        }else{
            $factura=Factura::find($id);
            $detalle=Abono::where('id_factura',$id)->get();
            if($detalle->count()>0)
            {
                foreach ($detalle as $query){
                    if($query->tipo_servicio==1){
                        $servicio="Internet";
                    }else{
                        $servicio="Television";
                    }
                    $results[] = [ 'cantidad' => '1', 'producto' => $servicio,'precio' => $query->abono,'subtotal'=>$query->abono];
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
            $xdatos['iva']=$factura->iva;
            $xdatos['sumas']=$factura->sumas;
            $xdatos['total']=$factura->total;
            $xdatos['direccion']=$factura->get_cliente->dirreccion.' '. strtoupper($factura->get_cliente->get_municipio->nombre).' '.strtoupper($factura->get_cliente->get_municipio->get_departamento->nombre);
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
    {
        Factura::destroy($id);
        if($cuota==1)
        {
            Abono::where('id_factura', $id)->delete();
        }else{
            Factura_detalle::where('id_factura', $id)->delete();
        }
        $obj_controller_bitacora=new BitacoraController();	
        $obj_controller_bitacora->create_mensaje('Factura eliminado con  id: '.$id);
        flash()->success("Registro eliminado exitosamente!")->important();
        return redirect()->route('facturacion.gestion');
    }

    public function anular($id)
    {
        Factura::where('id',$id)->update(['anulada' =>1]);
        flash()->success("Factura anulada exitosamente!")->important();
        return redirect()->route('facturacion.gestion');
    }

    // Autocomplete de Cliente
    public function busqueda_cliente(Request $request){
        $term1 = $request->term;
        $results = array();
        $queries = Cliente::
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
    public function guardar(Request $request)
    {   
        if ($request->cuantos >0)
        { 
            if(Factura::where('tipo_documento',$request->tipo_impresion)->where('numero_documento',$request->numdoc)->exists())
            {
                
                $xdatos['typeinfo']='Warning';
                $xdatos['msg']='el número de documento ya fue impreso.';
                return response($xdatos);
            }else
            { // AHORITA NO GUARDA LOS ABONOS CUANDO SON MESES ANTICIPOS
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
                        $abono->abono=$fila['cuota'];
                        $abono->precio=$fila['precio'];
                        $abono->anulado=0;
                        $abono->pagado=1;
                        $abono->save();
                        if($abono)
                        {
                            if($fila['id']!=0)
                            {
                                Abono::where('id',$fila['id'])->update(['pagado' =>'1']);
                            }
                        }
                    }
                    Cobrador::where('id',$request->id_cobrador)->update(['recibo_ultimo' =>$request->numreci]);
                    $this->setCorrelativo($request->tipo_impresion);
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
        if($tipo_ser==1){$contrato= Internet::select('cuota_mensual')->where('id_cliente',$id_cliente)->where('activo','1')->get(); }
        if($tipo_ser==2){$contrato= Tv::select('cuota_mensual')->where('id_cliente',$id_cliente)->where('activo','1')->get(); }
        $results2 = array();
        if(count($contrato)!=0)
        {
            $precio=$contrato[0]->cuota_mensual;
            $abono= Abono::where('id_cliente',$id_cliente)->where('tipo_servicio',$tipo_ser)->where('cargo','0.00')->where('pagado','1')->get();
            $abono1=$abono->last();
            $results2 = array();
            if(true)
            {
                if($filas==0)
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
                    
                }
                if($filas>0)
                {   $filas =$filas+1;
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
                }
            }else
            {
                $xdatos['typeinfo']='Warning';
                $xdatos['msg']='Cliente no posee abonos, debe tener al menos uno!';
                $xdatos['results']=$results2;
                return response($xdatos);
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
                        if($request->tipo_impresion==1){$tipo="FAC";}
                        if($request->tipo_impresion==2){$tipo="CRE";}
                        $Fdetalle = new Factura_detalle();
                        $Fdetalle->id_factura=$id_factura;
                        $Fdetalle->id_producto=$fila['id'];
                        $Fdetalle->cantidad=$fila['cantidad'];
                        $Fdetalle->precio=$fila['precio_venta'];
                        $Fdetalle->subtotal = $fila['subtotal'];
                        $Fdetalle->save();
                    }
                    //Cobrador::where('id',$request->id_cobrador)->update(['recibo_ultimo' =>$request->numreci]);
                    $this->setCorrelativo($request->tipo_impresion);
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
        return view('facturacion/index3',compact('obj_factura'));
    }
    public function imprimir_factura($id,$efectivo,$cambio){
        $factura = Factura::find($id);

        if($factura->tipo_documento==1){
            
            $fpdf = new FpdfFactura('P','mm', array(155,240));
           
            $fpdf->AliasNbPages();
            $fpdf->AddPage();
            $fpdf->SetTitle('FACTURA FINAL | UNINET');
    
            $fpdf->SetXY(115,40);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode(date('d/m/Y')));
    
            $fpdf->SetXY(20,47);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->nombre));
    
            $fpdf->SetXY(22,54);
            $fpdf->SetFont('Courier','',8);
            $direccion = substr($factura->get_cliente->dirreccion,0,50);
            $fpdf->Cell(20,10,utf8_decode($direccion));
    
    
            $fpdf->SetXY(22,61);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->dui));
    
            $fpdf->SetXY(39,68);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->telefono1));
    
            $fpdf->SetFont('Courier','',10);

            $formatter = new NumeroALetras();

            $letras = $formatter->toInvoice($factura->total, 2, 'DOLARES');

            $fpdf->SetXY(16,164);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($letras));


            $fpdf->SetXY(132,165);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->sumas,2)));


            $fpdf->SetXY(132,200);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->total,2)));
           
            $y=83;
        }

        if($factura->tipo_documento==2){
            
            $fpdf = new FpdfFactura('P','mm', array(163,240));

            $detalle_factura = Abono::where('id_factura',$id)->get();
            $fpdf->AliasNbPages();
            $fpdf->AddPage();
            $fpdf->SetTitle('FACTURA CREDITO| UNINET');
        
            $fpdf->SetXY(115,53);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode(date('d/m/Y')));
        
            $fpdf->SetXY(115,58);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->numero_registro));
        
            $fpdf->SetXY(115,63);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->nit));
        
            $fpdf->SetXY(115,68);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->giro));
        
            $fpdf->SetXY(20,53);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->nombre));
        
            $fpdf->SetXY(23,63);
            $fpdf->SetFont('Courier','',8);
            $direccion = substr($factura->get_cliente->dirreccion,0,45);
            $fpdf->Cell(20,10,utf8_decode($direccion));
        
            
            $fpdf->SetXY(23,68);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->get_municipio->nombre));
        
            $fpdf->SetXY(65,68);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($factura->get_cliente->get_municipio->get_departamento->nombre));
        
        
            $fpdf->SetFont('Courier','',10);

            
            $formatter = new NumeroALetras();
            $letras = $formatter->toInvoice($factura->total, 2, 'DOLARES');

            $fpdf->SetXY(16,161);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode($letras));


            $fpdf->SetXY(132,161);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->sumas,2)));

            $fpdf->SetXY(132,169);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->sumas*0.13,2)));

            $fpdf->SetXY(132,177);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->total,2)));

            $fpdf->SetXY(132,184);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format(0,2)));


            $fpdf->SetXY(132,201);
            $fpdf->SetFont('Courier','',10);
            $fpdf->Cell(20,10,utf8_decode('$ '.number_format($factura->total,2)));
           
            $y=92;
        }
        if($factura->cuota==1){

            $detalle_factura = Abono::where('id_factura',$id)->get();

            foreach ($detalle_factura as $value) {
                if($value->tipo_servicio==1){
                    $internet = Internet::where('id_cliente',$value->id_cliente)->where('activo',1)->get();
                    //$fecha_i=$internet->dia_gene_fact.''.date('/m/Y');
                    $concepto = "SERVICIO DE INTERNET ".$internet[0]->velocidad;
                    $concepto1 = 'DESDE '.$value->mes_servicio->format('d/m/Y')." HASTA ".date("d/m/Y",strtotime($value->mes_servicio."+ 1 month"));
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode(1));
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto));
                    $y+=5;
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto1));
                    $y-=5;
                    $fpdf->SetXY(132,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->abono,2)));
                    $y+=10;
    
                }else{
                    $tv = Tv::where('id_cliente',$value->id_cliente)->where('activo',1)->get();
                    $concepto = "SERVICIO DE TELEVISIÓN";
                    $concepto1 = 'DESDE '.$value->mes_servicio->format('d/m/Y')." HASTA ".date("d/m/Y",strtotime($value->mes_servicio."+ 1 month"));
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode(1));
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto));
                    $y+=7;
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto1));
                    $y-=7;
                    $fpdf->SetXY(132,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->abono,2)));
                    $y+=14;
    
                }
               
               
            }
        }else{

            $detalle_factura = Factura_detalle::where('id_factura',$id)->get();

            foreach ($detalle_factura as $value) {
                if($value->tipo_servicio==1){
                   
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->cantidad));
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->get_producto->nombre));
                    $fpdf->SetXY(132,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    $y+=5;
    
                }else{
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->cantidad));
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($value->get_producto->nombre));
                    
                    $fpdf->SetXY(132,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    $y+=7;
    
                }
               
               
            }


        }
        $fpdf->Output();
        exit;
    }

}
