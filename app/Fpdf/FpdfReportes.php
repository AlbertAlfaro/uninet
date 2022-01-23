<?php

namespace App\Fpdf;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Internet;

class FpdfReportes extends Fpdf{

    function Header()
    {
        if ( $this->PageNo() == 1 ) {
           
            // Logo
            $this->Image('assets/images/LOGO.png',10,5,60,25); //(x,y,w,h)
            // Arial bold 15
            $this->SetFont('Arial','B',22);
            // Movernos a la derecha
            $this->SetXY(80,10);
            // Título
            $this->Cell(30,10,'TECNNITEL S.A de C.V.');
            $this->SetXY(81,16);
            $this->SetFont('Arial','',12);
            $this->Cell(30,10,'SERVICIO DE TELECOMUNICACIONES');
        }
        
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }

    function BasicTable_contrato_vence($data){
        $this->SetFont('Arial','B',9);
        $this->Cell(20,7,utf8_decode('C. Cliente'),1,0,'C');
        $this->Cell(60,7,utf8_decode('Nombre'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Nº Contrato'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Cuota mensual'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Tipo de servicio'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Vencimiento'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Dias'),1,0,'C');

        $this->Ln();

        $this->SetFont('Arial','',9);

        foreach($data as $row){
            if($row->get_cliente->id_sucursal==Auth::user()->id_sucursal){

                $this->Cell(20,6,$row->get_cliente->codigo,0,0,'C');
                $this->Cell(60,6,$row->get_cliente->nombre,0,0,'');
                $this->Cell(26,6,$row->numero_contrato,0,0,'C');
                $this->Cell(26,6,'$ '.number_format($row->cuota_mensual,2),0,0,'');
                if($row->identificador==1){
                    $servicio = 'Internet';
                }else{
                    $servicio = 'Televisión';
    
                }
                $this->Cell(26,6,utf8_decode($servicio),0,0,'C');
    
                $this->Cell(20,6,$row->contrato_vence->format('d/m/Y'),0,0,'C');
                $this->Cell(20,6,$this->dias_pasados($row->contrato_vence->format('Y/m/d'),date('Y/m/d')),0,0,'C');
            }

            $this->Ln();

        }
    }

    function BasicTable_clientes($data,$servicio){
        $this->SetFont('Arial','B',9);
        $this->Cell(13,7,utf8_decode('#'),'B',0,'C');
        $this->Cell(13,7,utf8_decode('Código'),'B',0,'C');
        $this->Cell(73,7,utf8_decode('Nombre'),'B',0,'C');
        $this->Cell(23,7,utf8_decode('Departamento'),'B',0,'C');
        $this->Cell(15,7,utf8_decode('Teléfono'),'B',0,'C');
        $this->Cell(20,7,utf8_decode('Dui'),'B',0,'C');
        if($servicio==""){
            $this->Cell(15,7,utf8_decode('Internet'),'B',0,'C');
            $this->Cell(9,7,utf8_decode('Mbs'),'B',0,'C');
            $this->Cell(15,7,utf8_decode('Tv'),'B',0,'C');
        }elseif($servicio==1){//internet
            $this->Cell(15,7,utf8_decode('Internet'),1,0,'C');
            $this->Cell(9,7,utf8_decode('Mbs'),'B',0,'C');
        }elseif($servicio==2){//tv
            $this->Cell(17,7,utf8_decode('Tv'),'B',0,'C');
        }
        $this->Ln();

        $this->SetFont('Arial','',9);
        $m=0;
        $n=0;
        foreach($data as $row){
            $i = Internet::select('velocidad')->where('activo',1)->where('id_cliente',$row->id)->get();
            $n++;
            $this->Cell(13,7,$n,0,0,'C');
            $this->Cell(13,7,utf8_decode($row->codigo),0,0,'C');
            $this->Cell(73,7,utf8_decode($row->nombre),0,0,'');
            if($row->id_municipio!=""){

                $this->Cell(23,7,utf8_decode($row->get_municipio->get_departamento->nombre),0,0,'');
            }else{
                $this->Cell(23,7,utf8_decode(''),0,0,'');

            }
            $this->Cell(15,7,utf8_decode($row->telefono1),0,0,'C');
            $this->Cell(20,7,utf8_decode($row->dui),0,0,'C');
            if($row->internet==3){
                $einter = 'Vencido';
            }
            if($row->internet==2){
                $einter = 'Suspendido';
            }
            if($row->internet==1){
                $einter = 'Activo';
            }
            if($row->internet==0){
                $einter = 'Inactivo';
            }

            if($row->tv==3){
                $etv = 'Vencido';
            }
            if($row->tv==2){
                $etv = 'Suspendido';
            }
            if($row->tv==1){
                $etv = 'Activo';
            }
            if($row->tv==0){
                $etv = 'Inactivo';
            }
            if($servicio==""){
                $this->Cell(15,7,utf8_decode($einter),0,0,'C');
                if(isset($i[0]->velocidad)){
                    $this->Cell(9,7,$i[0]->velocidad,0,0,'C');
                    $porciones = explode(" ", $i[0]->velocidad);
                    $porciones[0];
                    $m+=$porciones[0];
                }else{
                    $this->Cell(9,7,'-',0,0,'C');
                }
                $this->Cell(17,7,utf8_decode($etv),0,0,'C');
            }elseif($servicio==1){//internet
                $this->Cell(15,7,utf8_decode($einter),0,0,'C');
                if(isset($i[0]->velocidad)){
                    $this->Cell(9,7,$i[0]->velocidad,0,0,'C');
                    $porciones = explode(" ", $i[0]->velocidad);
                    $porciones[0];
                    $m+=$porciones[0];
                }else{
                    $this->Cell(9,7,'-',0,0,'C');
                }
            }elseif($servicio==2){//tv
                $this->Cell(17,7,utf8_decode($etv),0,0,'C');
            }
           
           $this->Ln();

        }
        $this->Cell(193,1,'','B',0,'C');
        $this->Ln();
        $this->Cell(13,7,'',0,0,'C');
        $this->Cell(73,7,'',0,0,'C');
        $this->Cell(26,7,'',0,0,'C');
        $this->Cell(20,7,'',0,0,'C');
        $this->Cell(20,7,'',0,0,'C');
        if($servicio==""){
            $this->Cell(15,7,'Total: ',0,0,'C');
            $this->Cell(9,7,$m.' Mbs','B',0,'C');
        }elseif($servicio==1){//internet
            $this->Cell(17,7,'Total: ','B',0,'C');
            $this->Cell(9,7,$m.' Mbs','B',0,'C');
        }

    }
    
    function megas_vendidos($data){
        $this->SetFont('Arial','',9);
        $v=0;
        foreach($data as $row){
            $mb = explode(" ", $row->velocidad);
            $velocidad=$mb[0];
            $v+=$velocidad;
            //$this->Ln();
        }
        $this->SetX(90);
        $this->Cell(20,7,'VENDIDO:',1,0,'C');
        $this->Cell(20,7,$v.' Mbs',1,0,'C');
    }

    function BasicTable_pago_servicios($data,$estado_pago){
        $this->SetFont('Arial','B',9);
        $this->Cell(20,7,utf8_decode('C. Cliente'),1,0,'C');
        $this->Cell(75,7,utf8_decode('Nombre'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Cargo'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Tipo de servicio'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Vencimiento'),1,0,'C');
        $this->Cell(10,7,utf8_decode('Dias'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Estado'),1,0,'C');

        $this->Ln();

        $this->SetFont('Arial','',9);

        foreach($data as $row){
            if($estado_pago==1){

                $this->Cell(20,6,$row->get_cliente->codigo,0,0,'C');
                $this->Cell(75,6,$row->get_cliente->nombre,0,0,'');
                $this->Cell(20,6,'$ '.number_format($row->cargo,2),0,0,'C');
                if($row->tipo_servicio==1){
                    $servicio = 'Internet';
                }else{
                    $servicio = 'Televisión';
    
                }
                $this->Cell(26,6,utf8_decode($servicio),0,0,'C');
    
                $this->Cell(20,6,$row->fecha_vence->format('d/m/Y'),0,0,'C');
                $this->Cell(10,6,$this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')),0,0,'C');
    
                if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) == 0){
                    $this->Cell(26,6,utf8_decode('A pagar hoy'),0,0,'C');
    
                }
                if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) > 0){
                    $this->Cell(26,6,utf8_decode('A tiempo'),0,0,'C');
    
                }
                if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) < 0){
                    $this->Cell(26,6,utf8_decode('Vencido'),0,0,'C');
    
                }
                $this->Ln();
            }
            if($estado_pago==2){
                if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) < 0){

                    $this->Cell(20,6,$row->get_cliente->codigo,0,0,'C');
                    $this->Cell(75,6,$row->get_cliente->nombre,0,0,'');
                    $this->Cell(20,6,'$ '.number_format($row->cargo,2),0,0,'C');
                    if($row->tipo_servicio==1){
                        $servicio = 'Internet';
                    }else{
                        $servicio = 'Televisión';
        
                    }
                    $this->Cell(26,6,utf8_decode($servicio),0,0,'C');
        
                    $this->Cell(20,6,$row->fecha_vence->format('d/m/Y'),0,0,'C');
                    $this->Cell(10,6,$this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')),0,0,'C');
        
                    if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) == 0){
                        $this->Cell(26,6,utf8_decode('A pagar hoy'),0,0,'C');
        
                    }
                    if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) > 0){
                        $this->Cell(26,6,utf8_decode('A tiempo'),0,0,'C');
        
                    }
                    if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) < 0){
                        $this->Cell(26,6,utf8_decode('Vencido'),0,0,'C');
        
                    }

                    $this->Ln();

                }
            }

            if($estado_pago==3){
                if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) > 0){

                    $this->Cell(20,6,$row->get_cliente->codigo,0,0,'C');
                    $this->Cell(75,6,$row->get_cliente->nombre,0,0,'');
                    $this->Cell(26,6,'$ '.number_format($row->cargo,2),0,0,'');
                    if($row->tipo_servicio==1){
                        $servicio = 'Internet';
                    }else{
                        $servicio = 'Televisión';
        
                    }
                    $this->Cell(26,6,utf8_decode($servicio),0,0,'C');
        
                    $this->Cell(20,6,$row->fecha_vence->format('d/m/Y'),0,0,'C');
                    $this->Cell(10,6,$this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')),0,0,'C');
        
                    if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) == 0){
                        $this->Cell(26,6,utf8_decode('A pagar hoy'),0,0,'C');
        
                    }
                    if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) > 0){
                        $this->Cell(26,6,utf8_decode('A tiempo'),0,0,'C');
        
                    }
                    if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) < 0){
                        $this->Cell(26,6,utf8_decode('Vencido'),0,0,'C');
        
                    }

                    $this->Ln();
                }
            }



        }
    }

    function dias_pasados($fecha_inicial,$fecha_final){
    
        $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
        return $dias;
        //$dias = abs($dias); $dias = floor($dias);
    }


}