<?php

namespace App\Fpdf;

use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;


class FpdfEstadoCuenta extends Fpdf{

     // Cabecera de página
    function Header()
    {
        if ( $this->PageNo() == 1 ) {
           
            // Logo
            $this->Image('assets/images/LOGO.png',10,5,50,20); //(x,y,w,h)
            // Arial bold 15
            $this->SetFont('Arial','B',18);
            // Movernos a la derecha
            $this->SetXY(65,10);
            // Título
            $this->Cell(30,10,'TECNNITEL S.A de C.V.');
            $this->SetXY(66,16);
            $this->SetFont('Arial','',10);
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

    // Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = $file;
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    }

    function BasicTable($header, $data)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        // Header
        $this->SetFont('Arial','B',9);
        /*foreach($header as $col)
           $this->Cell(26,7,$col,1);
          

        $this->Ln();*/
        // Data
        //$header=array('N resivo','Codigo de cobrador','Tipo servicio','N comprobante','Mes de servicio',utf8_decode('Aplicación'),'Vencimiento','Cargo','Abono', 'Impuesto','Total');
        $this->Cell(24,7,utf8_decode('N resivo'),1,0,'C');
        $this->Cell(26,7,utf8_decode('C. Cobrador'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Tipo servicio'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Nº comprobante'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Mes servicio'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Aplicación'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Vencimiento'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Cargo'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Abono'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Impuesto'),1,0,'C');
        $this->Cell(20,7,utf8_decode('Total'),1,0,'C');

        $this->Ln();

        $this->SetFont('Arial','',9);
        $total_cargo = null;
        $total_abono =null;
        $a=0;
        $c=0;
        $x=0;
        //while($x<60){
        foreach($data as $row)
        {
            $c=0;
            $a=0;
            $this->Cell(24,6,$row->recibo,0,0,'C');
            $this->Cell(26,6,$row->id_cobrador,0,0,'C');
            if($row->tipo_servicio==1){
                $servicio = 'Internet';
            }else{
                $servicio = 'Televisión';

            }
           
            $this->Cell(26,6,utf8_decode($servicio),0,0,'C');
            $this->Cell(26,6,$row->numero_documento,0,0,'C');
            if($row->mes_servicio!=""){

                $this->Cell(26,6,$meses[($row->mes_servicio->format('n'))-1].' del '.$row->mes_servicio->format('Y'),0,0,'C');
            }else{
                $this->Cell(26,6,$row->mes_servicio,0);
            }
            if($row->fecha_aplicado!=""){

                $this->Cell(26,6,$row->fecha_aplicado->format('d/m/Y'),0,0,'C');
            }else{
                $this->Cell(26,6,$row->fecha_aplicado,0);
            }
            if($row->fecha_vence!=""){

                $this->Cell(26,6,$row->fecha_vence->format('d/m/Y'),0,0,'C');
            }else{
                $this->Cell(26,6,$row->fecha_vence,0);
            }
          
            $this->Cell(20,6,number_format($row->cargo,2),0,0,'C');
            $this->Cell(20,6,number_format($row->abono,2),0,0,'C');
          
            if($row->cargo!=0){

                $this->Cell(20,6,number_format($row->cesc_cargo,2),0,0,'C');
                $impuesto = $row->cesc_cargo;
                $c=$row->cargo;
                $x=$row->cargo;
            }
            if($row->abono!=0){

                $this->Cell(20,6,number_format($row->cesc_abono,2),0,0,'C');
                $impuesto = $row->cesc_abono;
                $a=$row->abono;
                $x=$row->abono;
            }
            $total = $impuesto+$c;
            $total_a = $impuesto+$a;
            $this->Cell(20,6,number_format($impuesto+$x,2),0,0,'C');
            
            $total_abono+=$total_a;
            $total_cargo+=$total;
            
            $this->Ln();
        }
        //$x++;
   // }
        $total_pago = $total_cargo-$total_abono;
        $this->SetFont('Arial','B',9);
        $this->SetX(240);
        $this->Cell(30,6,utf8_decode('TOTAL A COBRAR'),0,0,'C');
        $this->Ln();
        $this->SetX(240);
        $this->Cell(30,6,number_format($total_pago,2),1,0,'C');
    }

    function BasicTable_pendientes($header, $data)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        // Header
        $this->SetFont('Arial','B',9);
        /*foreach($header as $col)
           $this->Cell(26,7,$col,1);
          

        $this->Ln();*/
        // Data
        //$header=array('N resivo','Codigo de cobrador','Tipo servicio','N comprobante','Mes de servicio',utf8_decode('Aplicación'),'Vencimiento','Cargo','Abono', 'Impuesto','Total');
        $this->Cell(20,7,utf8_decode('ID'),1,0,'C');
        $this->Cell(85,7,utf8_decode('Cliente'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Mes de servicio'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Tipo servicio'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Vencimiento'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Dias restntes'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Estado'),1,0,'C');
        $this->Cell(26,7,utf8_decode('Cargo'),1,0,'C');
      

        $this->Ln();

        $this->SetFont('Arial','',9);
        $total_cargo = null;
        $estado = null;
        //while($x<60){
        foreach($data as $row)
        {
            $this->Cell(20,6,$row->id,0,0,'C');
            $this->Cell(85,6,utf8_decode('('.$row->get_cliente->codigo.') '.$row->get_cliente->nombre),0,0,'');

            if($row->tipo_servicio==1){
                $servicio = 'Internet';
            }else{
                $servicio = 'Televisión';
                
            }
           
            if($row->mes_servicio!=""){
                
                $this->Cell(26,6,$meses[($row->mes_servicio->format('n'))-1].' del '.$row->mes_servicio->format('Y'),0,0,'C');
            }else{
                $this->Cell(26,6,$row->mes_servicio,0);
            }
            $this->Cell(26,6,utf8_decode($servicio),0,0,'C');
            if($row->fecha_vence!=""){
                
                $this->Cell(26,6,$row->fecha_vence->format('d/m/Y'),0,0,'C');
            }else{
                $this->Cell(26,6,$row->fecha_vence,0);
            }
            $dias_restantes =$this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d'));
            $this->Cell(26,6,$dias_restantes,0,0,'C');
            if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) >0){$estado='A tiempo';}
            if($this->dias_pasados($row->fecha_vence->format('Y/m/d'),date('Y/m/d')) <0){$estado='Vencido';}

            $this->Cell(26,6,$estado,0,0,'C');
            $this->Cell(26,6,number_format($row->cargo,2),0,0,'C');
            $total_cargo+=$row->cargo;
          
            
            $this->Ln();
        }

        $this->SetFont('Arial','B',9);
        $this->SetX(245);
        $this->Cell(26,6,utf8_decode('TOTAL'),0,0,'C');
        $this->Ln();
        $this->SetX(246);
        $this->Cell(26,6,number_format($total_cargo,2),1,0,'C');
  
    }

    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Header
        $w = array(40, 35, 40, 45);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach($data as $row)
        {
            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w),0,'','T');
    }

    function dias_pasados($fecha_inicial,$fecha_final){
    
        $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
        return $dias;
        //$dias = abs($dias); $dias = floor($dias);
    }
    



}