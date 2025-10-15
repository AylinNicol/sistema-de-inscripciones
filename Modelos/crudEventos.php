<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$nombre_evento = (isset($_POST['nombre_evento'])) ? $_POST['nombre_evento'] : '';
$tipo_evento = (isset($_POST['tipo_evento'])) ? $_POST['tipo_evento'] : '';
$carrera = (isset($_POST['carrera'])) ? $_POST['carrera'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';
$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : '';
$material = (isset($_POST['material'])) ? $_POST['material'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_evento = (isset($_POST['cod_evento'])) ? $_POST['cod_evento'] : '';
switch($opcion){
    case 1: //alta*/
        $consulta= "INSERT INTO eventos (nombre_evento, fecha_inicio, fecha_fin, carrera, material, costo, tipo_evento) 
                    VALUES('$nombre_evento', '$fecha_inicio', '$fecha_fin', '$carrera', '$material', '$costo', '$tipo_evento')";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * 
                    FROM eventos 
                    ORDER BY cod_evento 
                    DESC LIMIT 1";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 2: //modificación
        $consulta= "UPDATE eventos SET nombre_evento ='$nombre_evento', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', carrera = '$carrera', material = '$material', costo ='$costo', tipo_evento = '$tipo_evento'
                    WHERE cod_evento = '$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT * 
                    FROM eventos 
                    WHERE cod_evento='$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 3://baja
        $consulta= "DELETE FROM eventos 
                    WHERE cod_evento ='$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * 
                    FROM eventos 
                    WHERE cod_evento='$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 4://ver poster
        $consulta= "SELECT poster 
                    FROM eventos 
                    WHERE cod_evento='$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 5://subir poster
        if (isset($_FILES['poster']) && $_FILES['poster']['size'] > 0) {
            $poster = $_FILES["poster"];
            $archivoPoster = $_FILES["poster"]["tmp_name"];
            $informacionImagen = getimagesize($archivoPoster);
                if ($informacionImagen !== false && ($informacionImagen['mime'] == 'image/jpeg' || $informacionImagen['mime'] == 'image/png')) {
                    $ruta_destino_poster = '../img/poster/';
                    $nombre_archivo_poster = $poster["name"];
                    $ubicacion_temporal_poster = $poster["tmp_name"];
                    $ruta_completa_poster = $ruta_destino_poster . $nombre_archivo_poster;
                    if (move_uploaded_file($ubicacion_temporal_poster, $ruta_completa_poster)) {
                        $poster = $nombre_archivo_poster;
                        $consulta= "UPDATE eventos SET poster = '$poster' 
                                    WHERE cod_evento = '$cod_evento'";
                        $resultado = mysqli_query($conexion,$consulta);
            
                        $consulta= "SELECT poster 
                                    FROM eventos 
                                    WHERE cod_evento='$cod_evento'";
                        $resultado = mysqli_query($conexion,$consulta);
                        $data = $resultado->fetch_all(MYSQLI_ASSOC);
                    } else {
                        $data = null;
                    }
                } else {
                    $data = null;
                }
        } else {
            $data = null;
        }
        break;
    case 6://ver certificado
        $consulta= "SELECT certificado 
                    FROM eventos 
                    WHERE cod_evento='$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 7://subir certificado
        if (isset($_FILES['certificado']) && $_FILES['certificado']['size'] > 0) {
            $certificado = $_FILES["certificado"];
            $archivoCertificado = $_FILES["certificado"]["tmp_name"];
            $informacionImagen = getimagesize($archivoCertificado);
            if ($informacionImagen !== false && ($informacionImagen['mime'] == 'image/jpeg' || $informacionImagen['mime'] == 'image/png')) {
                $ruta_destino_certificado = '../img/certificado/';
                $nombre_archivo_certificado = $certificado["name"];
                $ubicacion_temporal_certificado = $certificado["tmp_name"];
                $ruta_completa_certificado = $ruta_destino_certificado . $nombre_archivo_certificado;
                if (move_uploaded_file($ubicacion_temporal_certificado, $ruta_completa_certificado)) {
                    $certificado = $nombre_archivo_certificado;
                    $consulta= "UPDATE eventos SET certificado = '$certificado' 
                                WHERE cod_evento = '$cod_evento'";
                    $resultado = mysqli_query($conexion,$consulta);

                    $consulta= "SELECT certificado FROM eventos 
                                WHERE cod_evento='$cod_evento'";
                    $resultado = mysqli_query($conexion,$consulta);
                    $data = $resultado->fetch_all(MYSQLI_ASSOC);
                } else {
                    $data = null;
                }
            } else {
                $data = null;
            }
        } else {
            $data = null;
        }
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>