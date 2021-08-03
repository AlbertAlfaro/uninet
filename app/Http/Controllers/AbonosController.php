<?php

namespace App\Http\Controllers;

use App\Fpdf\FpdfEstadoCuenta;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Internet;
use App\Models\Tv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbonosController extends Controller
{
    public function index(){
        $id=0;
        $abono_inter = Abono::where('tipo_servicio',1)->where('pagado',0)->get();
        $abono_tv = Abono::where('tipo_servicio',2)->where('pagado',0)->get();

        return view('abonos.index',compact('abono_inter','abono_tv','id'));
    }

    private function spanishMes($m){
        $x=1;
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        foreach ($meses as $value) {
            if($m==$x){
                return $value;
            }
            $x++;
            
        }
    }

    public function abonos_pendientes_pdf($id,$tipo_servicio,$fecha_i,$fecha_f){

        $cliente = Cliente::find($id); 
        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $fecha_i);
        $fecha_fin = Carbon::createFromFormat('Y-m-d', $fecha_f);
        $estado_cuenta = Abono::select('id','id_cliente','id_cobrador','tipo_servicio','mes_servicio','cargo','fecha_vence','cargo','abono','cesc_cargo','cesc_abono')
                                ->whereBetween('created_at',[$fecha_inicio,$fecha_fin])
                                ->where('tipo_servicio',$tipo_servicio)
                                ->where('pagado',0)
                                ->get();
        $internet = Internet::where('activo',1)->get();
        $tv = Tv::where('activo',1)->get();
        $fpdf = new FpdfEstadoCuenta('L','mm', 'Letter');
        $fpdf->AliasNbPages();
        $fpdf->AddPage();
        $fpdf->SetTitle('PENDIENTES DE PAGO | UNINET');

        $fpdf->SetXY(250,10);
        $fpdf->SetFont('Arial','',8);
     
        $fpdf->Cell(20,10,utf8_decode('PÁGINAS: 000'.'{nb}'),0,1,'R');

        $fpdf->SetXY(250,15);
        $fpdf->SetFont('Arial','',8);
        $fpdf->Cell(20,10,utf8_decode('GENERADO POR: '.Auth::user()->name).' '.date('d/m/Y h:i:s a'),0,1,'R');

        $fpdf->SetXY(15,25);
        $fpdf->SetFont('Arial','B',9);
        $por_fecha_i = explode("-", $fecha_i);
        $por_fecha_f = explode("-", $fecha_f);
        $fpdf->Cell(20,10,utf8_decode('PENDIENTES DE PAGO del '.$por_fecha_i[2].' de '.$this->spanishMes($por_fecha_i[1]).' de '.$por_fecha_i[0].'  al '.$por_fecha_f[2].' de '.$this->spanishMes($por_fecha_f[1]).' de '.$por_fecha_f[0]));

        $fpdf->SetXY(15,29);
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE USULUTAN'));
        $fpdf->Ln();
    
        //$fpdf->SetXY(250,33); 
        $fpdf->SetFont('Arial','B',9);
       
       
       

        $header=array('N resivo','Codigo de cobrador','Tipo servicio','N comprobante','Mes de servicio',utf8_decode('Aplicación'),'Vencimiento','Cargo','Abono', 'Impuesto','Total');
        
        $fpdf->BasicTable_pendientes($header,$estado_cuenta);



        $fpdf->Output();
        exit;

    }
}
