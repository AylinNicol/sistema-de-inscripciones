<?php
require('fpdf/fpdf.php');
include "../../Modelos/conexion.php";//llamamos a la conexion BD

$consulta="SELECT ci, nombres_participante, apellidos_participante, celular, institucion, COUNT(cod_inscripcion) AS cantidad
            FROM participantes p, inscripciones i
            WHERE p.cod_participante = i.cod_participante
            GROUP BY p.cod_participante
            ORDER BY apellidos_participante";
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
        $this->Cell(0, 15, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "REPORTE GENERAL DE PARTICIPANTES"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
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
        $this->Cell(50, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "APELLIDOS"), 1, 0, 'C', 1);
        $this->Cell(50, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "NOMBRES"), 1, 0, 'C', 1);
        $this->Cell(23, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "C.I."), 1, 0, 'C', 1);
        $this->Cell(23, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CELULAR"), 1, 0, 'C', 1);
        $this->Cell(84, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CARRERA O INSTITUCIÓN"), 1, 0, 'C', 1);
        $this->Cell(23, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CANT. EV."), 1, 1, 'C', 1);
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
    $pdf->Cell(50, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['apellidos_participante']), 1, 0, 'L', 0);
    $pdf->Cell(50, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['nombres_participante']), 1, 0, 'L', 0);
    $pdf->Cell(23, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['ci']), 1, 0, 'L', 0);
    if($dat['celular'] == null){
        $celular = "";
    }else{
        $celular = $dat['celular'];
    }
    $pdf->Cell(23, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $celular), 1, 0, 'L', 0);
    $pdf->Cell(84, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['institucion']), 1, 0, 'L', 0);
    $pdf->Cell(23, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $dat['cantidad']), 1, 1, 'L', 0);
    $i = $i + 1;
}

$pdf->Output('ReporteParticipantes_'.date('Y-m-d').'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>