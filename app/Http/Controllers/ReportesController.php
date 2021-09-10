<?php

namespace App\Http\Controllers;

use App\Fpdf\FpdfReportes;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use Carbon\Carbon;
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
        if($request->tipo_reporte==1){
            $this->meses_faltantes($request->fecha_i,$request->fecha_f);
        }
        if($request->tipo_reporte==2){
            $this->pago_servicios($request->fecha,$request->estado_pago);
        }
        if($request->tipo_reporte==3){
            $this->general_clientes($request->fecha_i,$request->fecha_f);
        }
    }

    private function general_clientes($fecha_i,$fecha_f){
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha_i);
        $fecha_fin = Carbon::createFromFormat('d/m/Y', $fecha_f);

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
        $clientes = Cliente::where('id_sucursal',Auth::user()->id_sucursal)->whereBetween('created_at',[$fecha_inicio,$fecha_fin])->get();

        $fpdf->Ln();
        $fpdf->BasicTable_clientes($clientes);

        

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
            $tipo ="A pagar hoy";
        }
        if($estado_pago==2){
            $tipo ="Vencidos";
        }
        if($estado_pago==3){
            $tipo ="A tiempo";
        }

        $fpdf->SetXY(95,44);
        $fpdf->SetFont('Arial','',9);
        $fpdf->Cell(20,10,utf8_decode($tipo.' ('.$fecha.')'));

        $fpdf->Ln();
        $fpdf->BasicTable_pago_servicios($estado_cuenta,$estado_pago);


        $fpdf->Output();
        exit;

    }

    private function meses_faltantes($fecha_i,$fecha_f){
        $fecha_inicio = Carbon::createFromFormat('d/m/Y', $fecha_i);
        $fecha_fin = Carbon::createFromFormat('d/m/Y', $fecha_f);
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
}
