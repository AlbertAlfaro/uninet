<?php

namespace App\Fpdf;
use Codedge\Fpdf\Fpdf\Fpdf;


class FpdfClass extends Fpdf{

     // Cabecera de página
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
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

}