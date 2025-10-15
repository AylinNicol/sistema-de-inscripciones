<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$cod_inscripcion = (isset($_POST['cod_inscripcion'])) ? $_POST['cod_inscripcion'] : '';
$consulta= "SELECT cod_inscripcion, pago 
            FROM inscripciones 
            WHERE cod_inscripcion = '$cod_inscripcion'";
$resultado = mysqli_query($conexion,$consulta);
if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
    $dat = $resultado->fetch_assoc();
    $pago = $dat['pago'];
    if ($pago === "SI") {
        $data = $dat;
    }else{
        $data = 1;
    }
}else{
    $data=null;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>