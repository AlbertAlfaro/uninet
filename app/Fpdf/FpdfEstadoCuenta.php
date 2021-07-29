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
        foreach($header as $col)
            $this->Cell(26,7,$col,1);
        $this->Ln();
        // Data

        $this->SetFont('Arial','',9);
        $total_pagar = null;
        $x=0;
        //while($x<60){
        foreach($data as $row)
        {
            $this->Cell(26,6,$row->recibo,0,0,'C');
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
          
            $this->Cell(26,6,$row->cargo,0,0,'C');
            $this->Cell(26,6,$row->abono,0,0,'C');
            if($row->cargo!=""){

                $this->Cell(26,6,$row->cesc_cargo,0,0,'C');
                $impuesto = $row->cesc_cargo;
                $c=$row->cargo;
            }
            if($row->abono!=""){

                $this->Cell(26,6,$row->cesc_abono,0,0,'C');
                $impuesto = $row->cesc_abono;
                $c=$row->abono;
            }
            $total = $impuesto+$c;
            $this->Cell(26,6,$total,0,0,'C');
            $total_pagar+=$total;

            
            
            $this->Ln();
        }
        //$x++;
   // }
        $this->SetFont('Arial','B',9);
        $this->SetX(240);
        $this->Cell(30,6,utf8_decode('TOTAL A COBRAR'),0,0,'C');
        $this->Ln();
        $this->SetX(240);
        $this->Cell(30,6,$total_pagar,1,0,'C');
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



}