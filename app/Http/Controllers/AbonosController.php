<?php

namespace App\Http\Controllers;

use App\Fpdf\FpdfEstadoCuenta;
use App\Fpdf\FpdfFactura;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Factura_detalle;
use App\Models\Internet;
use App\Models\Producto;
use App\Models\Tv;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;;
use Illuminate\Support\Facades\Auth;

class AbonosController extends Controller
{
    public function __construct(){
        // verifica si la session esta activa
        $this->middleware('auth');
    }
    
    public function index(){
        $id=0;
        $abono_inter = Abono::join('clientes','abonos.id_cliente','=','clientes.id')
                            ->where('abonos.tipo_servicio',1)
                            ->where('abonos.pagado',0)
                            ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
                            ->get();
        $abono_tv = Abono::join('clientes','abonos.id_cliente','=','clientes.id')
                            ->where('abonos.tipo_servicio',2)
                            ->where('abonos.pagado',0)
                            ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
                            ->get();

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
                                ->whereBetween('abonos.created_at',[$fecha_inicio,$fecha_fin])
                                ->where('abonos.tipo_servicio',$tipo_servicio)
                                ->where('abonos.pagado',0)
                                ->where('clientes.id_sucursal',Auth::user()->id_sucursal)
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
        $fpdf->Cell(20,10,utf8_decode('SUCURSAL DE '.Auth::user()->get_sucursal->nombre));
        $fpdf->Ln();
    
        //$fpdf->SetXY(250,33); 
        $fpdf->SetFont('Arial','B',9);
       
       
       

        $header=array('N resivo','Codigo de cobrador','Tipo servicio','N comprobante','Mes de servicio',utf8_decode('Aplicación'),'Vencimiento','Cargo','Abono', 'Impuesto','Total');
        
        $fpdf->BasicTable_pendientes($header,$estado_cuenta);



        $fpdf->Output();
        exit;

    }

    public function imprimir_factura($id){

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
                    $concepto1 = 'DESDE '.date("d/m/Y",strtotime($value->mes_servicio."- 1 month"))." HASTA ".$value->mes_servicio->format('d/m/Y');
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode(1));
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto));
                    $y+=5;
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto1));
                    $y-=5;
                    $fpdf->SetXY(132,$y);
                    $fpdf->Cell(20,10,utf8_decode('$ '.number_format($value->precio,2)));
                    $y+=10;
    
                }else{
                    $tv = Tv::where('id_cliente',$value->id_cliente)->where('activo',1)->get();
                    $concepto = "SERVICIO DE TELEVISIÓN";
                    $concepto1 = 'DESDE '.date("d/m/Y",strtotime($value->mes_servicio."- 1 month"))." HASTA ".$value->mes_servicio->format('d/m/Y');
    
    
                    $fpdf->SetXY(10,$y);
                    $fpdf->Cell(20,10,utf8_decode(1));
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto));
                    $y+=7;
                    $fpdf->SetXY(22,$y);
                    $fpdf->Cell(20,10,utf8_decode($concepto1));
                    $y-=7;
                    $fpdf->SetXY(132,$y);
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
