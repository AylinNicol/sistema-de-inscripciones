<?php
require('fpdf/fpdf.php');
include "../../Modelos/conexion.php";//llamamos a la conexion BD

$consulta ="SELECT e.cod_evento, nombre_evento, fecha_inicio, fecha_fin, COUNT(cod_inscripcion) AS cantidad, costo, SUM(costo-(costo*promocion)) AS subtotal
            FROM eventos e, inscripciones i
            WHERE e.cod_evento=i.cod_evento
            GROUP BY e.cod_evento;";
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
        $this->Cell(0, 15, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CÁLCULO DE EVENTOS"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
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
        $this->Cell(52, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "FECHAS"), 1, 0, 'C', 1);
        $this->Cell(15, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "COSTO"), 1, 0, 'C', 1);
        $this->Cell(12, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CANT."), 1, 0, 'C', 1);
        $this->Cell(25, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "SUBTOTAL"), 1, 0, 'C', 1);
        $this->Cell(21, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CANT.PAG."), 1, 0, 'C', 1);
        $this->Cell(27, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "SUB. ACTUAL"), 1, 1, 'C', 1);
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
$total_actual = 0;
$total = 0;
foreach($data as $dat) {
    $codigo = $dat['cod_evento'];
    $consulta="SELECT SUM(costo-(costo*promocion)) AS subtotalquehay, COUNT(cod_inscripcion) AS cant
                FROM eventos.eventos e, eventos.inscripciones i
                WHERE e.cod_evento = i.cod_evento AND pago = 'SI' AND e.cod_evento = '$codigo'
                GROUP BY e.cod_evento;";
    $resultado = mysqli_query($conexion,$consulta);
    $dato = $resultado->fetch_assoc();
    $cant = $dato['cant'];
    $sub_actual = $dato['subtotalquehay'];
    $sub_actual = round($sub_actual, 2);
    $subtotal = round($dat['subtotal'], 2);

    $pdf->Cell(10, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $i), 1, 0, 'L', 0);
    $pdf->Cell(100, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['nombre_evento']), 1, 0, 'L', 0);
    $pdf->Cell(52, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['fecha_inicio']. " A ". $dat['fecha_fin']), 1, 0, 'L', 0);
    $pdf->Cell(15, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['costo'])." Bs.", 1, 0, 'L', 0);
    $pdf->Cell(12, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['cantidad']), 1, 0, 'L', 0);
    $pdf->Cell(25, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Bs. ".$subtotal), 1, 0, 'R', 0);
    $pdf->Cell(21, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $cant), 1, 0, 'L', 0);
    $pdf->Cell(27, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Bs. ".$sub_actual), 1, 1, 'R', 0);
    $i = $i + 1;
    $total_actual = $total_actual + $sub_actual;
    $total = $total + $subtotal;
}
$pdf->SetFillColor(19, 178, 141); //colorFondo
$pdf->SetTextColor(255, 255, 255); //colorTexto
$pdf->SetDrawColor(255, 255, 255); //colorBorde
$pdf->SetFont('Courier', 'B', 11);
$pdf->Cell(189, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "TOTAL"), 1, 0, 'R', 1);

$pdf->SetTextColor(0, 0, 0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Courier', '', 11);
$pdf->Cell(25, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Bs. ".$total), 1, 0, 'R', 0);

$pdf->SetFillColor(19, 178, 141); //colorFondo
$pdf->SetTextColor(255, 255, 255); //colorTexto
$pdf->SetDrawColor(255, 255, 255); //colorBorde
$pdf->SetFont('Courier', 'B', 11);
$pdf->Cell(21, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", ""), 1, 0, 'R', 1);

$pdf->SetTextColor(0, 0, 0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Courier', '', 11);
$pdf->Cell(27, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Bs. ".$total_actual), 1, 1, 'R', 0);

$pdf->Output('CalculoEventos_'.date('Y-m-d').'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>