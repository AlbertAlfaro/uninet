<?php

namespace App\Http\Controllers;
use App\Models\Cobrador;
use App\Models\Correlativo;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use App\Models\Abono;
use App\Models\Factura;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Luecano\NumeroALetras\NumeroALetras;
use App\Models\Producto;

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
    public function destroy($id)
    {
        //
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
    {    $results = array();
        if($servicio==0 || $servicio==1)
        {
            if($servicio==1)//1=internet
            {
                $servi=Cliente::where('id',$id_cliente)->where('internet','1')->count();
                $mensaje="Cliente no posee Internet activo!";
    
            }
            if($servicio==0)//0=television
            {
                $servi=Cliente::where('id',$id_cliente)->where('tv','1')->count();
                $mensaje="Cliente no posee Tv activo!";
    
            }
            if($servi>0)
            {   $abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->where('pagado','0')->get();
                if($abono)
                {
                    foreach ($abono as $query){
                        $cargo_sin_iva=$query->cargo/1.13;
                        $results[] = [ 'id' => $query->id, 'cargo' => $query->cargo,'mes_servicio' => $query->mes_servicio->format('m/Y'),'fecha_vence'=>$query->fecha_vence->format('d/m/Y'),'mes_ser'=>$query->mes_servicio->format('Y/m/d'),'cargo_sin_iva'=>$cargo_sin_iva];
                    }
                }else
                {
                    $results=[];
                }
           
              return response($results);   
               /*$abono = Abono::where('id_cliente',$id_cliente)->where('abono','0.00')->get();
                return response()->json(
                    $abono-> toArray()  
                );*/
            }else
            {
                return $mensaje;
            
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
                
                return "Este documento ya fue impreso";
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
                    return "Guradado con exito";
                }else
                {
                    return "no se puedo guardar la fctura";
                }
            }
            
        }else{
            return "No hay abonos para ingresar";
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
        //1=internet y 0=television
        if($tipo_ser==1){$contrato= Internet::select('cuota_mensual')->where('id_cliente',$id_cliente)->where('activo','1')->get(); }
        if($tipo_ser==0){$contrato= Tv::select('cuota_mensual')->where('id_cliente',$id_cliente)->where('activo','1')->get(); }
        $results2 = array();
        if(count($contrato)!=0)
        {
            $precio=$contrato[0]->cuota_mensual;
            $abono= Abono::where('id_cliente',$id_cliente)->where('tipo_servicio',$tipo_ser)->where('pagado','1')->get();
            $abono1=$abono->last();
            $results2 = array();
            if($filas==0)
            {
             
                $mes_servicio=date("d-m-Y", strtotime($abono1->mes_servicio."+ 1 month"));
                $mes_ser=date("Y/m/d", strtotime($abono1->mes_servicio."+ 1 month"));
                $fecha_vence=date("d/m/Y", strtotime($mes_servicio."+ 10 days"));
                $cargo_sin_iva=$precio/1.13;

                $results2[] = [ 
                    'id' => $abono1->id,
                    'cargo' => $precio,
                    'mes_servicio' =>$mes_servicio,
                    'fecha_vence'=>$fecha_vence,
                    'mes_ser'=>$mes_ser,
                    'cargo_sin_iva'=>$cargo_sin_iva,
                ];
                return response($results2);
                
            }
            if($filas>0)
            {   $filas =$filas+1;
                $mes_servicio=date("d-m-Y", strtotime($abono1->mes_servicio."+ ".$filas." month"));
                $mes_ser=date("Y/m/d", strtotime($abono1->mes_servicio."+ ".$filas." month"));
                $fecha_vence=date("d/m/Y", strtotime($mes_servicio."+ 10 days"));
                $cargo_sin_iva=$precio/1.13;
                $results2[] = [ 
                    'id' => $abono1->id,
                    'cargo' => $precio,
                    'mes_servicio' =>$mes_servicio,
                    'fecha_vence'=>$fecha_vence,
                    'mes_ser'=>$mes_ser,
                    'cargo_sin_iva'=>$cargo_sin_iva,
                ];
                return response($results2);
            }
        }else
        {

            return response($results2);
        }

    }

    //------------COMIENZA LAS FUNCIONES DE LA FACTURA MANUAL
    public function index2()
    {
        $obj_cobrador = Cobrador::all();
        return view('facturacion/index2', compact('obj_cobrador'));


    }
    public function busqueda_cliente2(Request $request){
        $term1 = $request->term;
        $results = array();
        $queries = Producto::
        Where('nombre', 'LIKE', '%'.$term1.'%')->
        Where('id_sucursal',Auth::user()->id_sucursal)->
        get();    
        foreach ($queries as $query){
            $precio_sin_iva=$query->precio/1.13;
            $results[] = [ 'id' => $query->id, 'value' => $query->nombre,'nombre' => $query->nombre,'precio'=>$query->precio,'precio_sin_iva'=>$precio_sin_iva];
        }
        return response($results);       
    
    } 
}
