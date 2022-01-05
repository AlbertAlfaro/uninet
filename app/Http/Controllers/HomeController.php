<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Internet;
use App\Models\Tv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $cliente = Cliente::where('activo',1)->where('internet',1)->get();
        $clientes=$cliente->count();
        $fecha_inicio = date('Y-m-d 00:00:00');
        $fecha_fin = date('Y-m-d 23:59:59');
        $factura = Factura::where('anulada',0)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
        $total_fac=0;
        foreach ($factura as $value) {
           $total_fac+=$value->total;
        }

        $cargos_pen = Abono::where('pagado',0)->where('anulado',0)->get();
        $total_pen=0;
        foreach ($cargos_pen as $value1) {
           $total_pen+=1;
        }

        $suspendidos_inter = Internet::where('activo',2)->get()->count();
        $suspendidos_tv = Tv::where('activo',2)->get()->count();
        $suspendidos = $suspendidos_inter + $suspendidos_tv;


        //para la grafica.
        $fecha_actual = date('Y-m-d');
        $fecha_ini = strtotime ( '-1 year' , strtotime ( $fecha_actual ) ) ;
        $fecha_ini = date ( 'Y-m-d' , $fecha_ini );
        //return $fecha_ini;
        $data_int=array();
        $data_tv=array();
        $productos=array();
        $fecha="";
        $fechas = array();
        $total_full=0;
        for($x=0;$x<12;$x++){
            $total=0;
            $total1=0;
            $total2=0;
            if($x==0){

                $fecha_i = $fecha_ini;
            }else{
                //$dd = strtotime ( '-1 days' , strtotime ( $fecha ) );
                $fecha_i = $fecha;
            }
            $fecha = strtotime ( '+1 month' , strtotime ( $fecha_i ) ) ;
            $fecha = date ( 'Y-m-d' , $fecha );

            $fecha_inicial = $fecha_i.' 00:00:00';
            //$fecha_final = $fecha.' 23:59:59';
            $fecha_final = strtotime ( '-0 days' , strtotime ( $fecha ) ) ;
            $fecha_final = date ( 'Y-m-d' , $fecha_final ).' 23:59:59';

           // echo $fecha_inicial.' '.$fecha_final.' - ';
            $fechas[$x] = date('m/d/Y', strtotime($fecha_final));
           // echo $fecha_final.' ';
            $dat_in = Factura::join('abonos','facturas.id','=','abonos.id_factura')
                                ->where('abonos.tipo_servicio',1)
                                ->where('facturas.anulada',0)
                                ->whereBetween('facturas.created_at',[$fecha_inicial,$fecha_final])->get();
            
            $dat_tv = Factura::join('abonos','facturas.id','=','abonos.id_factura')
                                ->where('abonos.tipo_servicio',2)
                                ->where('facturas.anulada',0)
                                ->whereBetween('facturas.created_at',[$fecha_inicial,$fecha_final])->get();

            $produc = Factura::where('anulada',0)->where('cuota',0)->whereBetween('created_at',[$fecha_inicial,$fecha_final])->get();
            
            foreach ($dat_in as $value) {
                $total+= $value->total;
                
            }

            foreach ($dat_tv as $value1) {
                $total1+= $value1->total;
                
            }

            foreach ($produc as $value2) {
                $total2+= $value2->total;
                
            }
            //echo $total2;
            $data_int[$x]=$total;
            $data_tv[$x]=$total1;
            $productos[$x]=$total2;

            $total_full += $total+$total1+$total2;

        }
        $total_ventas = Factura::where('anulada',0)->count(); 
        $fecha_fin = Carbon::createFromFormat('d/m/Y', date('d/m/Y'));
        $estado_cuenta = Abono::select(
                                        'abonos.id',
                                        'abonos.id_cliente',
                                        'abonos.id_cobrador',
                                        'abonos.tipo_servicio',
                                        'abonos.mes_servicio',
                                        'abonos.cargo',
                                        'abonos.fecha_vence',
                                        'abonos.cargo',
                                        'abonos.abono',
                                        'abonos.cesc_cargo',
                                        'abonos.cesc_abono',
                                        'clientes.id_sucursal',
                                        'clientes.nombre'
                                        )
                                    ->join('clientes','abonos.id_cliente','=','clientes.id')
                                    ->where('abonos.pagado',0)
                                    ->where('abonos.anulado',0)
                                    ->where('abonos.fecha_vence',$fecha_fin->format('Y-m-d'))
                                    ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
                                    ->get(); 
        //return $productos;
        return view('index',compact('clientes','total_fac','total_pen','suspendidos','data_int','data_tv','fechas','productos','total_full','total_ventas','estado_cuenta'));
    }
}
