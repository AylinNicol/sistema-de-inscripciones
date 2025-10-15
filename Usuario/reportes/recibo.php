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

function numeroEnLetra($numero) {
    $num = $numero;
    $unidades = array('', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
    $veinti = array('', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete', 'dieciocho', 'diecinueve');
    $decenas = array('', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
    $centenas = array('', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');
    if ($numero == 0) {
        return 'cero';
    }
    $letra = '';
    // Centenas
    if ($numero >= 100) {
        $centena = floor($numero / 100);
        $letra .= $centenas[$centena];
        $numero %= 100;
    }
    // Decenas
    if ($numero >= 20 && $numero <= 99) {
        $decena = floor($numero / 10);
        $letra .= $decenas[$decena];
        $numero %= 10;
    }else{
        $numero %= 10;
    }
    // Unidades
    if ($numero > 0) {
        $letra .= $unidades[$numero];
    }
    // Veinti
    if ($num >= 11 && $num <= 19) {
        $num %= 10;
        $letra = $veinti[$num];
    }
    return strtoupper($letra);
}

date_default_timezone_set('America/La_Paz');

$consulta= "SELECT *
            FROM inscripciones i, participantes p, eventos e 
            WHERE i.cod_participante = p.cod_participante AND i.cod_evento = e.cod_evento AND cod_inscripcion = '$cod_inscripcion'";
$resultado = mysqli_query($conexion,$consulta);
$dat = $resultado->fetch_assoc();
$ci = $dat['ci'];
$nombres = $dat['nombres_participante'];
$apellidos = $dat['apellidos_participante'];
$nombre_evento = $dat['nombre_evento'];
$costo = $dat['costo'];
$promocion = $dat['promocion'];
$total = $costo-($costo*$promocion);
$promocion = $promocion*100;
$parte_entera = floor($total);
$parte_decimal = round(($total - $parte_entera) * 100);
if($parte_decimal > 0){
    $letra = numeroEnLetra($parte_entera)."  ".$parte_decimal;
}else{
    $letra = numeroEnLetra($parte_entera)."  00";
}
$fecha_actual = date('Y-m-d H:i:s');
class PDF extends FPDF {
    function Footer() {
        // Método Footer se llama automáticamente al final de cada página
        // Posicionar a 18 mm del fondo
        $this->SetY(-18); // Posición: a 1,5 cm del final
        // Fecha
        $fecha_actual = date('Y-m-d H:i:s');
        //color
        $this->SetFillColor(19, 178, 141); //colorFondo
        $this->SetTextColor(0, 0, 0); //colorTexto

        $this->SetFont('Courier', '', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(80, 3, $fecha_actual, 0, 1, 'R', 0);
        $this->Ln(1);
        $this->Cell(80, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Para más información visite:"), 0, 1, 'C', 0);
        $this->SetFont('Courier', '', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(80, 5, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "WWW.EVENTOSACADEMICOS.COM"), 0, 1, 'C', 0);
    }
}
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage("",[100,90]); // aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) 
$pdf->SetMargins(5,5,5);
//$pdf->setBottomMargin(10);
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetFillColor(0, 0, 0); //colorFondo
//Universidad Técnica de Oruro
$pdf->SetY(5);
$pdf->SetFont('Courier', '', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 3, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Universidad Técnica de Oruro"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//Facultad Nacional de Ingeniería
//$pdf->SetY(5);
$pdf->SetFont('Courier', '', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 3, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Facultad Nacional de Ingeniería"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//Ingeniería de Sistemas e Ingeniería Informática
//$pdf->SetY(5);
$pdf->SetFont('Courier', '', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 3, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Ingeniería de Sistemas e Ingeniería Informática"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//LINEA
$pdf->SetDrawColor(215, 215, 215); //color
$pdf->SetLineWidth(0.2); //establece el ancho de la línea
$pdf->Line(3, 15, 87, 15); //x1,y1,x2,y2

//COMPROBANTE DE PAGO
//$pdf->SetY(5);
$pdf->SetFont('Courier', 'B', 18); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 10, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "COMPROBANTE DE PAGO"), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//LINEA
$pdf->SetDrawColor(0, 0, 0); //color
$pdf->SetLineWidth(0.3); //establece el ancho de la línea
$pdf->Line(3, 23, 87, 23); //x1,y1,x2,y2

//cod_inscripcion
//$pdf->SetY(5);
$pdf->SetFont('Courier', '', 10); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(0, 3, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Código de Inscripción: ".$cod_inscripcion), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//Nombre
$pdf->SetY(30);
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Nombre: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $apellidos." ".$nombres), 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//CI
//$pdf->SetY(5);
$pdf->Ln(1);
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "C.I.: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ci), 0, 1, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0),

//LINEA ---
$pdf->SetTextColor(215, 215, 215); //color teexto
$pdf->SetFont('Arial', 'BU', 5); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(80, 1, "                                                                                                                                                                        ", 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(80, 1, "", 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//Evento
//$pdf->SetY(42);
$pdf->Ln(1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Evento: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $nombre_evento), 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),posicion(L-C-R),ColorFondo(1-0)

//LINEA ---
$pdf->SetTextColor(215, 215, 215); //
$pdf->SetFont('Arial', 'BU', 5); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(80, 1, "                                                                                                                                                                        ", 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->Cell(80, 1, "", 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//Costo evento
//$pdf->SetY(42);
$pdf->Ln(1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Costo: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Bs ".$costo), 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),posicion(L-C-R),ColorFondo(1-0)

//Promocion
//$pdf->SetY(42);
$pdf->Ln(1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Promoción: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', '', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->MultiCell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $promocion."%"), 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),posicion(L-C-R),ColorFondo(1-0)

//Total
//$pdf->SetY(42);
$pdf->Ln(1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Total: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', 'B', 11); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", ">> Bs ".$total." <<"), 0, 1, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//Son
//$pdf->SetY(42);
$pdf->Ln(1);
$pdf->SetFont('Courier', 'B', 9); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Son: "), 0, 0, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
$pdf->SetFont('Courier', '', 9); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
$pdf->Cell(55, 4, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $letra."/100 BS"), 0, 1, 'L', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)

//LINEA
$pdf->SetDrawColor(0, 0, 0); //color
$pdf->SetLineWidth(0.3); //establece el ancho de la línea
$pdf->Line(3, 86, 87, 86); //x1,y1,x2,y2


$pdf->Output('Recibo_'.$ci.'_'.date('Y-m-d').'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>