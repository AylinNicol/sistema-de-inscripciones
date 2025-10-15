<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$ci = (isset($_POST['ci'])) ? $_POST['ci'] : '';
$nombre_evento = (isset($_POST['nombre_evento'])) ? $_POST['nombre_evento'] : '';
$pago = (isset($_POST['pago'])) ? $_POST['pago'] : '';
$promocion = (isset($_POST['promocion'])) ? $_POST['promocion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_inscripcion = (isset($_POST['cod_inscripcion'])) ? $_POST['cod_inscripcion'] : '';
switch($opcion){
    case 1: //alta*/
        $consulta= "SELECT cod_evento 
                    FROM eventos 
                    WHERE nombre_evento='$nombre_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_evento = $dat['cod_evento'];

        $consulta= "SELECT cod_participante 
                    FROM participantes 
                    WHERE ci ='$ci'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_participante = $dat['cod_participante'];

        $prom=$promocion/100;

        $consulta= "INSERT INTO inscripciones (cod_evento, cod_participante, fecha_inscripcion, pago, promocion) 
                    VALUES ('$cod_evento', '$cod_participante', CURDATE(), '$pago', '$prom')";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT cod_inscripcion, nombre_evento, ci, fecha_inscripcion, pago, promocion  
                    FROM inscripciones i, eventos e, participantes p 
                    WHERE i.cod_evento=e.cod_evento AND i.cod_participante=p.cod_participante 
                    ORDER BY cod_inscripcion 
                    DESC LIMIT 1";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 2: //modificación
        $consulta= "SELECT cod_evento 
                    FROM eventos 
                    WHERE nombre_evento='$nombre_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_evento = $dat['cod_evento'];

        $consulta= "SELECT cod_participante 
                    FROM participantes 
                    WHERE ci ='$ci'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_participante = $dat['cod_participante'];

        $prom=$promocion/100;

        $consulta= "UPDATE inscripciones SET cod_evento='$cod_evento', cod_participante='$cod_participante', pago='$pago', promocion='$prom' 
                    WHERE cod_inscripcion='$cod_inscripcion'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT cod_inscripcion, nombre_evento, ci, fecha_inscripcion, pago, promocion 
                    FROM inscripciones i, eventos e, participantes p 
                    WHERE i.cod_evento=e.cod_evento AND i.cod_participante=p.cod_participante AND cod_inscripcion='$cod_inscripcion'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;   
    case 3://baja
        $consulta= "DELETE FROM inscripciones 
                    WHERE cod_inscripcion='$cod_inscripcion'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT cod_inscripcion, nombre_evento, ci, fecha_inscripcion, pago, promocion 
                    FROM inscripciones i, eventos e, participantes p 
                    WHERE i.cod_evento=e.cod_evento AND i.cod_participante=p.cod_participante AND cod_inscripcion='$cod_inscripcion'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>