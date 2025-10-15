<?php
require('fpdf/fpdf.php');
include "../../Modelos/conexion.php";//llamamos a la conexion BD

$consulta= "SELECT * FROM eventos";
$resultado = mysqli_query($conexion,$consulta);
$data = $resultado->fetch_all(MYSQLI_ASSOC);

class PDF extends FPDF{
    // Cabecera de página
    function Header(){
        //LOGO
        $this->Image('../../img/LOGO.png', 230, 5, 40); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
        
        //TITULO    
        $this->SetTextColor(6, 14, 70); //color
        //$this->Cell(77); // Movernos a la derecha
        $this->SetFont('Courier', 'B', 24); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        //creamos una celda o fila
        $this->Cell(0, 15, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "REPORTE GENERAL DE EVENTOS ACADÉMICOS"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(0); // Salto de línea

        //FECHA
        $this->SetTextColor(103); //color
        //$this->Cell(85);  // mover a la derecha
        $this->SetFont('Courier', 'B', 12);
        $this->Cell(0, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Fecha : ".date('Y-m-d')), 0, 0, 'C', 0);
        $this->Ln(13);

        /* CAMPOS DE LA TABLA */
        //color
        $this->SetFillColor(19, 178, 141); //colorFondo
        $this->SetTextColor(255, 255, 255); //colorTexto
        $this->SetDrawColor(255, 255, 255); //colorBorde
        $this->SetFont('Courier', 'B', 11);
        $this->Cell(10, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "N°"), 1, 0, 'C', 1);
        $this->Cell(100, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "NOMBRE"), 1, 0, 'C', 1);
        $this->Cell(70, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CARRERA"), 1, 0, 'C', 1);
        $this->Cell(15, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "COSTO"), 1, 0, 'C', 1);
        $this->Cell(32, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "FECHA INICIAL"), 1, 0, 'C', 1);
        $this->Cell(32, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "FECHA FINAL"), 1, 1, 'C', 1);
    }

    // Pie de página
    function Footer(){
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetTextColor(0, 0, 0); //colorTexto
        $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(0, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Página ") . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage("landscape","letter"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Courier', '', 10);
$i = 1;
foreach($data as $dat) {
    $pdf->Cell(10, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $i), 1, 0, 'L', 0);
    $pdf->Cell(100, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['nombre_evento']), 1, 0, 'L', 0);
    
    if($dat['carrera'] == "Ingeniería de Sistemas e Ingeniería Informática"){
        $carrera = "Ing. Sistemas e Ing. Informática";
    }else{
        $carrera = $dat['carrera'];
    }
    //$pdf->Cell(83, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Ing. Sistemas e Ing. Informática"), 1, 0, 'L', 0);
    $pdf->Cell(70, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $carrera), 1, 0, 'L', 0);
    $pdf->Cell(15, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['costo'])." Bs.", 1, 0, 'L', 0);
    $pdf->Cell(32, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['fecha_inicio']), 1, 0, 'L', 0);
    $pdf->Cell(32, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['fecha_fin']), 1, 1, 'L', 0);
    $i = $i + 1;
}

$pdf->Output('ReporteEventos_'.date('Y-m-d').'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>