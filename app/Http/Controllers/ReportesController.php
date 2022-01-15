<?php

namespace App\Http\Controllers;

use App\Fpdf\FpdfReportes;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use App\Models\Factura;
use App\Models\Ordenes;
use App\Models\Reconexion;
use App\Models\Suspensiones;
use App\Models\Traslados;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index($opcion){

        return view('reportes.index',compact('opcion'));
    }

    public function pdf(Request $request){
        //return $request->tipo_reporte;
        if($request->opcion=="Clientes"){
            if($request->tipo_reporte==1){
                $this->meses_faltantes($request->fecha_i,$request->fecha_f);
            }
            if($request->tipo_reporte==2){
                $this->pago_servicios($request->fecha,$request->estado_pago);
            }
            if($request->tipo_reporte==3){
                $this->general_clientes($request->fecha_i,$request->fecha_f,$request->estado_cliente,$request->servicio);
            }
            if($request->tipo_reporte==4){
                $this->general_megas($request->fecha_i,$request->fecha_f);
            }
            
        }
        if($request->opcion=="Facturas"){
            $this->facturas($request->fecha_i,$request->fecha_f,$request->tipo_reporte);
        
        }
        if($request->opcion=="Ordenes"){
            $this->Ordenes($request->fecha_i,$request->fecha_f,$request->tipo_reporte,$request->orden_estado);
        
        }


    }

    private function format_fecha($x,$date){
        if($x==1){
            $fch=explode("/",$date);
            $tfecha=$fch[2]."-".$fch[1]."-".$fch[0];
            $newDate = $tfecha." 00:00:00";
          
        }
        if($x==2){
            $fch=explode("/",$date);
            $tfecha=$fch[2]."-".$fch[1]."-".$fch[0];
            $newDate = $tfecha." 23:59:59";
        }

        return $newDate;

    }

    private function general_clientes($fecha_i,$fecha_f,$estado,$servicio){
      
        $fecha_inicio = $this->format_fecha(1,$fecha_i);
        $fecha_fin =  $this->format_fecha(2,$fecha_f);

    

        $fpdf = new FpdfReportes('P','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('CLIENTES | UNINET');

        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('Generado por '.Auth::user()->name).' '.date('d/m/Y h:i:s a'));
        $fpdf->SetXY(15,33);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));

        $fpdf->SetXY(88,40);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(20,10,utf8_decode('CLIENTES REGISTRADOS'));

        $fpdf->SetXY(95,44);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('desde '.$fecha_i.' hasta '.$fecha_f));
        if($estado=="" AND $servicio==""){
            $clientes = Cliente::where('clientes.id_sucursal',Auth::user()->id_sucursal)->whereBetween('clientes.created_at',[$fecha_inicio,$fecha_fin])->get();
        }elseif ($estado=="" AND $servicio!="") {
            if($servicio==1){
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->where('internet','!=','0')->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($servicio==2){
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->where('tv','!=','0')->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
        }elseif($estado!="" AND $servicio==""){
            if($estado==1){
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->where('tv','=','1')->orWhere('internet','=','1')->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==2){
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->where('tv','=','2')->orWhere('internet','=','2')->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==0){
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->where('tv','=','0')->orWhere('internet','=','0')->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
        }elseif($estado!="" AND $servicio!=""){
            if($servicio==1){//internet
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->Where('internet','=',$estado)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($servicio==2){//internet
                $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->Where('tv','=',$estado)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
            }
        }

        $fpdf->Ln();
        $fpdf->BasicTable_clientes($clientes,$servicio);

        

        $fpdf->Output();
        exit;


    }
    private function general_megas($fecha_i,$fecha_f){
        $fecha_inicio = $this->format_fecha(1,$fecha_i);
        $fecha_fin =  $this->format_fecha(2,$fecha_f);

    

        $fpdf = new FpdfReportes('P','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('CLIENTES | UNINET');

        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('Generado por '.Auth::user()->name).' '.date('d/m/Y h:i:s a'));
        $fpdf->SetXY(15,33);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));

        $fpdf->SetXY(88,40);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(20,10,utf8_decode('MEGAS VENDIDOS'));

        $fpdf->SetXY(95,44);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('desde '.$fecha_i.' hasta '.$fecha_f));
        $clientes = Internet::select('internets.velocidad')
                    ->join('clientes', 'internets.id_cliente', '=', 'clientes.id')
                    ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
                    ->where('internets.activo',1)
                    ->whereBetween('internets.created_at',[$fecha_inicio,$fecha_fin])->get();
       
        $fpdf->Ln();
        $fpdf->megas_vendidos($clientes);

        $fpdf->Output();
        exit;
    }

    private function pago_servicios($fecha,$estado_pago){

        //$fecha_fin = date('d/m/Y');
        if($fecha!=""){

            $fecha_fin = Carbon::createFromFormat('d/m/Y', $fecha);
        }else{
            $fecha = date('d/m/Y');
        }


        if($estado_pago==1){

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
                                            'clientes.id_sucursal'
                                            )
                                        ->join('clientes','abonos.id_cliente','=','clientes.id')
                                        ->where('abonos.pagado',0)
                                        ->where('abonos.fecha_vence',$fecha_fin->format('Y-m-d'))
                                        ->where('clientes.internet','=',1)
                                        ->orwhere('clientes.tv','=',1)
                                        ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
                                        ->get();
        }else{
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
                'clientes.id_sucursal'
                )
            ->join('clientes','abonos.id_cliente','=','clientes.id')
            ->where('abonos.pagado',0)
            ->where('clientes.internet','=',1)
            ->orwhere('clientes.tv','=',1)
            //->where('abonos.fecha_vence',$fecha_fin->format('Y-m-d'))
            ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
            ->get();

        }
    

        $fpdf = new FpdfReportes('P','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('PAGO SERVICIOS | UNINET');

        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('Generado por '.Auth::user()->name).' '.date('d/m/Y h:i:s a'));
        $fpdf->SetXY(15,33);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));

        $fpdf->SetXY(88,40);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(20,10,utf8_decode('PAGO DE SERVICIOS'));

        if($estado_pago==1){
            $tipo ="Ultima fecha de Pago";
        }
        if($estado_pago==2){
            $tipo ="Vencidos";
        }
        if($estado_pago==3){
            $tipo ="A tiempo";
        }

        $fpdf->SetXY(95,44);
        if($estado_pago==1){
            $fpdf->SetXY(89,44);
        }
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode($tipo.' ('.$fecha.')'));

        $fpdf->Ln();
        $fpdf->BasicTable_pago_servicios($estado_cuenta,$estado_pago);


        $fpdf->Output();
        exit;

    }

    private function meses_faltantes($fecha_i,$fecha_f){
        $fecha_inicio =  $this->format_fecha(1,$fecha_i);
        $fecha_fin =  $this->format_fecha(2,$fecha_f);
        $cliente_tv = Tv::select(
                            'id_cliente',
                            'numero_contrato',
                            'cuota_mensual',
                            'contrato_vence',
                            'identificador',
                            'activo',
                        )
                        ->whereBetween('contrato_vence',[$fecha_inicio,$fecha_fin])
                        ->where('activo',1);
        $cliente_inter = Internet::select(
                                        'id_cliente',
                                        'numero_contrato',
                                        'cuota_mensual',
                                        'contrato_vence',
                                        'identificador',
                                        'activo',
                                    )
                                    ->unionAll($cliente_tv)
                                    ->whereBetween('contrato_vence',[$fecha_inicio,$fecha_fin])
                                    ->where('activo',1)
                                    ->orderBy('contrato_vence', 'asc')
                                    ->get();
        
        //dd($cliente_inter);

        $fpdf = new FpdfReportes('P','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('CONTRATOS A VENCER | UNINET');
        
        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('Generado por '.Auth::user()->name).' '.date('d/m/Y h:i:s a'));
        $fpdf->SetXY(15,33);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));

        $fpdf->SetXY(85,40);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(20,10,utf8_decode('CONTRATOS A VENCER'));

        $fpdf->SetXY(89,44);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('desde '.$fecha_i.' hasta '.$fecha_f));
        
        $fpdf->Ln();
        $fpdf->BasicTable_contrato_vence($cliente_inter);

        $fpdf->Output();
        exit;
    }

    private function facturas($fecha_i,$fecha_f,$tipo_reporte){
        $fecha_inicio =  $this->format_fecha(1, $fecha_i);
        $fecha_fin =  $this->format_fecha(2, $fecha_f);

        $fpdf = new FpdfReportes('P','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('FACTURAS | UNINET');

        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('Generado por '.Auth::user()->name).' '.date('d/m/Y h:i:s a'));
        $fpdf->SetXY(15,33);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));

        $fpdf->SetXY(88,40);
        $fpdf->SetFont('Arial','B',14);
        $fpdf->Cell(20,10,utf8_decode('CORTE DE FACTURACION'));

        $fpdf->SetXY(95,44);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('desde '.$fecha_i.' hasta '.$fecha_f));
        if($tipo_reporte==0){
            $facturas = Factura::where('id_sucursal',Auth::user()->id_sucursal)->where('anulada',0)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();
        }
        if($tipo_reporte==1){
            $facturas = Factura::where('id_sucursal',Auth::user()->id_sucursal)->where('anulada',1)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();

        }
        if($tipo_reporte==2){
            $facturas = Factura::where('id_sucursal',Auth::user()->id_sucursal)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();            
        }
        $fpdf->Ln();
        //$fpdf->BasicTable_clientes($clientes);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,7,utf8_decode('Cobrador'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Documento'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Código'),1,0,'C');
        $fpdf->Cell(75,7,utf8_decode('Cliente'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Fecha'),1,0,'C');
        $fpdf->Cell(15,7,utf8_decode('Servicio'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Cantidad'),1,0,'C');
        $fpdf->Ln();
        $suma=0.00;
        $fpdf->SetFont('Arial','',9);
        foreach($facturas as $row){
            if($row->tipo_documento==1){$tipo='FAC';}
            if($row->tipo_documento==2){$tipo='CRE';}
            $fpdf->Cell(20,7,utf8_decode($row->get_cobrador->nombre),0,0,'');
            $fpdf->Cell(20,7,utf8_decode($tipo.'-'.$row->numero_documento),0,0,'C');
            $fpdf->Cell(20,7,utf8_decode($row->get_cliente->codigo),0,0,'C');
            $fpdf->Cell(75,7,utf8_decode($row->get_cliente->nombre),0,0,'L');
            $fpdf->Cell(20,7,$row->created_at->format("d/m/Y"),0,0,'L');
            //tipo servicio 
            if($row->tipo_servicio==1){$fpdf->Cell(15,7,'I',0,0,'C');}
            if($row->tipo_servicio==2){$fpdf->Cell(15,7,'Tv',0,0,'C');}
            if($row->tipo_servicio==0){$fpdf->Cell(15,7,'-',0,0,'C');}
            //fin de tipo servicio
            if($row->anulada==0){
                $fpdf->Cell(20,7,number_format($row->total,2),0,0,'C');
                $suma+=$row->total;
            }else{
                $fpdf->SetTextColor(194,8,8);
                $fpdf->Cell(20,7,utf8_decode("ANULADA"),0,0,'C');
                $fpdf->SetTextColor(0,0,0);
            }
            $fpdf->Ln();
        }
        $fpdf->Cell(20,7,'','B',0,'');
        $fpdf->Cell(20,7,'','B',0,'C');
        $fpdf->Cell(20,7,'','B',0,'C');
        $fpdf->Cell(75,7,'','B',0,'L');
        $fpdf->Cell(20,7,'','B',0,'R');
        $fpdf->Cell(20,7,'','B',0,'C');
        $fpdf->Ln();
        $fpdf->Cell(20,7,'',0,0,'');
        $fpdf->Cell(20,7,'',0,0,'C');
        $fpdf->Cell(20,7,'',0,0,'C');
        $fpdf->Cell(75,7,'',0,0,'L');
        $fpdf->Cell(20,7,'Total',0,0,'R');
        $fpdf->Cell(20,7,'$'.number_format($suma,2),0,0,'C');
        

        $fpdf->Output();
        exit;

    }

    private function Ordenes($fecha_i,$fecha_f,$tipo_reporte,$estado){
        $fecha_inicio = $this->format_fecha(1, $fecha_i);
        $fecha_fin =  $this->format_fecha(2, $fecha_f);

        $fpdf = new FpdfReportes('P','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('ORDENES | UNINET');

        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('Generado por '.Auth::user()->name).' '.date('d/m/Y h:i:s a'));
        $fpdf->SetXY(15,33);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));

        $fpdf->SetXY(88,40);
        $fpdf->SetFont('Arial','B',14);
        if($tipo_reporte==1){$fpdf->Cell(20,10,utf8_decode('ORDENES DE TRABAJO'));}
        if($tipo_reporte==2){$fpdf->Cell(20,10,utf8_decode('ORDENES DE SUSPENSION'));}
        if($tipo_reporte==3){$fpdf->Cell(20,10,utf8_decode('ORDENES DE RECONEXIONE'));}
        if($tipo_reporte==4){$fpdf->Cell(20,10,utf8_decode('ORDENES DE TRASLADO'));}
        if($tipo_reporte==5){$fpdf->Cell(20,10,utf8_decode('ORDENES DE SOPORTE'));}

        $fpdf->SetXY(95,44);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode('desde '.$fecha_i.' hasta '.$fecha_f));
        if($tipo_reporte==1){
            if($estado==1){
                
                $ordenes = Ordenes::join('clientes','ordenes.id_cliente','=','clientes.id')->where('ordenes.fecha_trabajo','!=',null)->whereBetween('ordenes.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==2){
                $ordenes = Ordenes::join('clientes','ordenes.id_cliente','=','clientes.id')->where('ordenes.fecha_trabajo','=',null)->whereBetween('ordenes.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==3 || $estado==''){
                $ordenes = Ordenes::join('clientes','ordenes.id_cliente','=','clientes.id')->whereBetween('ordenes.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
        }
        if($tipo_reporte==2){
            if($estado==1){
                $ordenes = Suspensiones::join('clientes','suspensiones.id_cliente','=','clientes.id')->where('suspensiones.fecha_trabajo','!=',null)->whereBetween('suspensiones.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==2){
                $ordenes = Suspensiones::join('clientes','suspensiones.id_cliente','=','clientes.id')->where('suspensiones.fecha_trabajo','=',null)->whereBetween('suspensiones.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==3 || $estado==''){
                $ordenes = Suspensiones::join('clientes','suspensiones.id_cliente','=','clientes.id')->whereBetween('suspensiones.created_at',[$fecha_inicio,$fecha_fin])->get();
            }

        }
        if($tipo_reporte==3){
            if($estado==1){
                $ordenes = Reconexion::join('clientes','reconexions.id_cliente','=','clientes.id')->where('reconexions.fecha_trabajo','!=',null)->whereBetween('reconexions.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==2){
                $ordenes = Reconexion::join('clientes','reconexions.id_cliente','=','clientes.id')->where('reconexions.fecha_trabajo','=',null)->whereBetween('reconexions.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==3 || $estado==''){
                $ordenes = Reconexion::join('clientes','reconexions.id_cliente','=','clientes.id')->whereBetween('reconexions.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
        }
        if($tipo_reporte==4){
            if($estado==1){
                $ordenes = Traslados::join('clientes','traslados.id_cliente','=','clientes.id')->where('traslados.fecha_trabajo','!=',null)->whereBetween('traslados.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==2){
                $ordenes = Traslados::join('clientes','traslados.id_cliente','=','clientes.id')->where('traslados.fecha_trabajo','=',null)->whereBetween('traslados.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
            if($estado==3 || $estado==''){
                $ordenes = Traslados::join('clientes','traslados.id_cliente','=','clientes.id')->whereBetween('traslados.created_at',[$fecha_inicio,$fecha_fin])->get();
            }
        }
        if($tipo_reporte==5){
            $ordenes = Ordenes::join('clientes','ordenes.id_cliente','=','clientes.id')->where('ordenes.soporte',1)->whereBetween('ordenes.created_at',[$fecha_inicio,$fecha_fin])->get();
            
        }
        $fpdf->Ln();
        //$fpdf->BasicTable_clientes($clientes);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(10,7,utf8_decode('#'),1,0,'C');
        $fpdf->Cell(30,7,utf8_decode('Fecha y Hora'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Orden'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Código'),1,0,'C');
        $fpdf->Cell(75,7,utf8_decode('Cliente'),1,0,'C');
        $fpdf->Cell(14,7,utf8_decode('Servicio'),1,0,'C');
        $fpdf->Cell(20,7,utf8_decode('Realizado'),1,0,'C');
        $fpdf->Ln();
        $suma=0.00;
        $n=1;
        $fpdf->SetFont('Arial','',9);
        foreach($ordenes as $row){
            $fpdf->Cell(10,7,utf8_decode($n),0,0,'C');
            $fpdf->Cell(30,7,$row->created_at->format("d/m/Y H:i:s"),0,0,'C');
            $fpdf->Cell(20,7,$row->numero,0,0,'C');
            $fpdf->Cell(20,7,$row->get_cliente->codigo,0,0,'L');
            $fpdf->Cell(75,7,$row->get_cliente->nombre,0,0,'L');
            if($row->tipo_servicio=='Internet'){
                $fpdf->Cell(14,7,'I',0,0,'C');
            }else{
                $fpdf->Cell(14,7,'T',0,0,'C');
            }
            if($row->fecha_trabajo!=null){
                $fpdf->Cell(20,7,$row->fecha_trabajo->format("d/m/Y"),0,0,'C');
            }else{
                $fpdf->Cell(20,7,'Pendiente',0,0,'C');
            }
            $fpdf->Ln();
            $n+=1;
        }        
        $fpdf->Output();
        exit;

    }
}
