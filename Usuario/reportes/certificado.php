<?php
if (strlen($_GET['cod_inscripcion'])>0) {
    $cod_inscripcion = $_GET['cod_inscripcion'];
}else{
    $cod_inscripcion = 0;
}
require('fpdf/fpdf.php');
include "../../Modelos/conexion.php";//llamamos a la conexion BD

function mesLetra($mes) {
    switch($mes){
        case 1: $mes = "Enero"; break;
        case 2: $mes = "Febrero"; break;
        case 3: $mes = "Marzo"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Mayo"; break;
        case 6: $mes = "Junio"; break;
        case 7: $mes = "Julio"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Septiembre"; break;
        case 10: $mes = "Octubre"; break;
        case 11: $mes = "Noviembre"; break;
        case 12: $mes = "Diciembre"; break;
    }
    return $mes;
}

$consulta= "SELECT *
            FROM inscripciones i, participantes p, eventos e 
            WHERE i.cod_participante = p.cod_participante AND i.cod_evento = e.cod_evento AND cod_inscripcion = '$cod_inscripcion'";
$resultado = mysqli_query($conexion,$consulta);
$dat = $resultado->fetch_assoc();
$certificado = $dat['certificado'];
$carrera = $dat['carrera'];
$ci = $dat['ci'];
$nombres = $dat['nombres_participante'];
$apellidos = $dat['apellidos_participante'];
$nombre_evento = $dat['nombre_evento'];
$fecha_inicio = $dat['fecha_inicio'];
$fecha_fin = $dat['fecha_fin'];
$fecha_i = new DateTime($fecha_inicio);
$fecha_f = new DateTime($fecha_fin);
$dia_i = $fecha_i->format('d');
$mes_i = $fecha_i->format('m');
$mes_i = mesLetra($mes_i);
$anio_i = $fecha_i->format('Y');
$dia_f = $fecha_f->format('d');
$mes_f = $fecha_f->format('m');
$mes_f = mesLetra($mes_f);
$anio_f = $fecha_f->format('Y');

// Creación del objeto de la clase heredada
$pdf = new FPDF();
$pdf->AddPage("landscape","letter"); // aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) 
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

//CERTIFICADO IMAGEN
$pdf->Image('../../img/certificado/'.$certificado, 0, 0, 280); //logo,moverDerecha,moverAbajo,tamañoIMG

//LOGOS
if($carrera == "Ingeniería de Sistemas"){
    $pdf->Image('../../img/certificado/CertSIS.png', 94, 5, 92); //logo,moverDerecha,moverAbajo,tamañoIMG
}else if($carrera == "Ingeniería Informática"){
    $pdf->Image('../../img/certificado/CertINF.png', 94, 5, 88); //logo,moverDerecha,moverAbajo,tamañoIMG
}else{
    $pdf->Image('../../img/certificado/CertSISINF.png', 80, 5, 125); //logo,moverDerecha,moverAbajo,tamañoIMG
}

//TITULO
if($carrera == "Ingeniería de Sistemas"){
    $pdf->SetXY(30,40);
    $titulo = "LA CARRERA DE INGENIERÍA DE SISTEMAS OTORGA";
}else if($carrera == "Ingeniería Informática"){
    $pdf->SetXY(30,40);
    $titulo = "LA CARRERA DE INGENIERÍA INFORMÁTICA OTORGA";
}else{
    $pdf->SetXY(30,35);
    $titulo = "LAS CARRERAS DE INGENIERÍA DE SISTEMAS E INGENIERÍA INFORMÁTICA OTORGAN";
}
$pdf->SetTextColor(6, 14, 70); //color
$pdf->SetFont('Arial', 'B', 15); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(220, 8, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $titulo." EL PRESENTE:"), 0, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),posicion(L-C-R),ColorFondo(1-0)

//CERTIFICADO DE PARTICIPACION
$pdf->SetY(55);
$pdf->SetFont('Arial', 'B', 40); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 15, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "CERTIFICADO DE PARTICIPACIÓN"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//A:
$pdf->SetY(68);
$pdf->SetFont('Arial', '', 20); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 15, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "A:"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//NOMBRE
$pdf->SetY(87);
$pdf->SetFont('Arial', 'BI', 36); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 15, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $apellidos." ".$nombres), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//LINEA
$pdf->SetDrawColor(6, 14, 70); //color
$pdf->SetLineWidth(1);
$pdf->Line(34, 102, 245, 102);

//TEXTO
$pdf->SetY(120);
$pdf->SetFont('Arial', '', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(220, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Por su participación en calidad de PARTICIPANTE en el Evento Académico ".$nombre_evento." desarrollado del ".$dia_i." de ".$mes_i." de ".$anio_i." al ".$dia_f." de ".$mes_f." de ".$anio_f."."), 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//FECHA
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, "Oruro, ".$mes_f." de ".$anio_f.".", 0, 1);

$pdf->Output('Certificado_'.$ci.'_'.date('Y-m-d').'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>