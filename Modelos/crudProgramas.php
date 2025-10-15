<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$nombre_evento = (isset($_POST['nombre_evento'])) ? $_POST['nombre_evento'] : '';
$tema = (isset($_POST['tema'])) ? $_POST['tema'] : '';
$hora_inicio = (isset($_POST['hora_inicio'])) ? $_POST['hora_inicio'] : '';
$hora_fin = (isset($_POST['hora_fin'])) ? $_POST['hora_fin'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$expositor = (isset($_POST['expositor'])) ? $_POST['expositor'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_programa = (isset($_POST['cod_programa'])) ? $_POST['cod_programa'] : '';
if($fecha != ''){
    $consulta= "SELECT fecha_inicio, fecha_fin 
                FROM eventos 
                WHERE nombre_evento='$nombre_evento'";
    $resultado = mysqli_query($conexion,$consulta);
    $dat = $resultado->fetch_assoc();
    $fechaAComparar = new DateTime($fecha);
    $fecha_inicio = new DateTime($dat['fecha_inicio']);
    $fecha_fin = new DateTime($dat['fecha_fin']);
    if ($fechaAComparar >= $fecha_inicio && $fechaAComparar <= $fecha_fin) {
        $vale = 1;
    } else {
        $vale = 0;
    }
}
if($hora_inicio != '' && $hora_fin != ''){
    $consulta= "SELECT cod_evento 
                FROM eventos 
                WHERE nombre_evento='$nombre_evento'";
    $resultado = mysqli_query($conexion,$consulta);
    $dat = $resultado->fetch_assoc();
    $cod_evento = $dat['cod_evento'];

    switch($opcion){
        case 1: //alta*/
        $consulta= "SELECT hora_inicio, hora_fin 
                    FROM programas 
                    WHERE cod_evento='$cod_evento' AND fecha='$fecha'";
        break;
        case 2: //modificación
        $consulta= "SELECT hora_inicio, hora_fin 
                    FROM programas 
                    WHERE cod_evento='$cod_evento' AND fecha='$fecha' AND cod_programa!='$cod_programa'";
        break;
    }
    $resultado = mysqli_query($conexion,$consulta);
    $datas = $resultado->fetch_all(MYSQLI_ASSOC);
    $nuevo_intervalo_no_superpuesto = true;
    foreach ($datas as $dat) {
        $hora_inicio_db = $dat['hora_inicio'];
        $hora_fin_db = $dat['hora_fin'];
        if (
            ($hora_inicio >= $hora_inicio_db && $hora_inicio < $hora_fin_db) ||
            ($hora_fin > $hora_inicio_db && $hora_fin <= $hora_fin_db) ||
            ($hora_inicio <= $hora_inicio_db && $hora_fin >= $hora_fin_db)
        ) {
            $nuevo_intervalo_no_superpuesto = false;
            break;
        }
    }
    if ($nuevo_intervalo_no_superpuesto) {
        $vale2 = 1;
    } else {
        $vale2 = 0;
    }
}
switch($opcion){
    case 1: //alta*/
        if($vale == 1 && $vale2 == 1){
            $consulta= "SELECT cod_evento 
                        FROM eventos 
                        WHERE nombre_evento='$nombre_evento'";
            $resultado = mysqli_query($conexion,$consulta);
            $dat = $resultado->fetch_assoc();
            $cod_evento = $dat['cod_evento'];

            $consulta= "SELECT cod_expositor 
                        FROM expositores 
                        WHERE CONCAT(nombres_expositor, ' ', apellidos_expositor) ='$expositor'";
            $resultado = mysqli_query($conexion,$consulta);
            $dat = $resultado->fetch_assoc();
            $cod_expositor = $dat['cod_expositor'];

            $consulta= "INSERT INTO programas (cod_evento, tema, hora_inicio, hora_fin, fecha, cod_expositor) 
                        VALUES ('$cod_evento', '$tema', '$hora_inicio', '$hora_fin', '$fecha', '$cod_expositor')";
            $resultado = mysqli_query($conexion,$consulta);

            $consulta= "SELECT cod_programa, nombre_evento, tema, hora_inicio, hora_fin, fecha, CONCAT(nombres_expositor, ' ', apellidos_expositor) AS expositor  
                        FROM programas p, eventos e, expositores ex 
                        WHERE p.cod_evento=e.cod_evento AND p.cod_expositor=ex.cod_expositor 
                        ORDER BY cod_programa 
                        DESC LIMIT 1";
            $resultado = mysqli_query($conexion,$consulta);
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
        }else{
            $data = null;
        }
        break;
    case 2: //modificación
        if($vale == 1 && $vale2 == 1){
            $consulta= "SELECT cod_evento 
                        FROM eventos 
                        WHERE nombre_evento='$nombre_evento'";
            $resultado = mysqli_query($conexion,$consulta);
            $dat = $resultado->fetch_assoc();
            $cod_evento = $dat['cod_evento'];

            $consulta= "SELECT cod_expositor 
                        FROM expositores 
                        WHERE CONCAT(nombres_expositor, ' ', apellidos_expositor) ='$expositor'";
            $resultado = mysqli_query($conexion,$consulta);
            $dat = $resultado->fetch_assoc();
            $cod_expositor = $dat['cod_expositor'];

            $consulta= "UPDATE programas SET cod_evento='$cod_evento', tema='$tema', hora_inicio='$hora_inicio', hora_fin='$hora_fin', fecha='$fecha', cod_expositor='$cod_expositor' 
                        WHERE cod_programa='$cod_programa'";
            $resultado = mysqli_query($conexion,$consulta);
            
            $consulta= "SELECT cod_programa, nombre_evento, tema, hora_inicio, hora_fin, fecha, CONCAT(nombres_expositor, ' ', apellidos_expositor) AS expositor
                        FROM programas p, eventos e, expositores ex 
                        WHERE p.cod_evento=e.cod_evento AND p.cod_expositor=ex.cod_expositor AND cod_programa='$cod_programa'";
            $resultado = mysqli_query($conexion,$consulta);
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
        }else{
            $data = null;
        }
        break;        
    case 3://baja
        $consulta= "DELETE FROM programas 
                    WHERE cod_programa='$cod_programa'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT cod_programa, nombre_evento, tema, hora_inicio, hora_fin, fecha, CONCAT(nombres_expositor, ' ', apellidos_expositor) AS expositor
                    FROM programas p, eventos e, expositores ex 
                    WHERE p.cod_evento=e.cod_evento AND p.cod_expositor=ex.cod_expositor AND cod_programa='$cod_programa'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>