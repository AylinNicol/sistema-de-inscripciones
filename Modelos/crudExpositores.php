<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$ci_expositor = (isset($_POST['ci_expositor'])) ? $_POST['ci_expositor'] : '';
$nombres_expositor = (isset($_POST['nombres_expositor'])) ? $_POST['nombres_expositor'] : '';
$apellidos_expositor = (isset($_POST['apellidos_expositor'])) ? $_POST['apellidos_expositor'] : '';
$celular_expositor = (isset($_POST['celular_expositor'])) ? $_POST['celular_expositor'] : '';
$correo_expositor = (isset($_POST['correo_expositor'])) ? $_POST['correo_expositor'] : '';
$nacionalidad = (isset($_POST['nacionalidad'])) ? $_POST['nacionalidad'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_expositor = (isset($_POST['cod_expositor'])) ? $_POST['cod_expositor'] : '';
switch($opcion){
    case 1: //alta*/
        $consulta= "SELECT * FROM expositores WHERE ci_expositor = '$ci_expositor'";
        $resultado = mysqli_query($conexion,$consulta);
        if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
            $data = null;
        }else{
            $consulta= "INSERT INTO expositores (ci_expositor,nombres_expositor, apellidos_expositor, correo_expositor, celular_expositor, nacionalidad) 
                        VALUES('$ci_expositor', '$nombres_expositor', '$apellidos_expositor', '$correo_expositor', '$celular_expositor', '$nacionalidad')";
            $resultado = mysqli_query($conexion,$consulta);

            $consulta= "SELECT * 
                        FROM expositores 
                        ORDER BY cod_expositor 
                        DESC LIMIT 1";
            $resultado = mysqli_query($conexion,$consulta);
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
        }
        break;
    case 2: //modificación
        $consulta= "UPDATE expositores SET ci_expositor = '$ci_expositor', nombres_expositor = '$nombres_expositor', apellidos_expositor = '$apellidos_expositor', correo_expositor = '$correo_expositor', celular_expositor = '$celular_expositor', nacionalidad = '$nacionalidad'
                    WHERE cod_expositor = '$cod_expositor'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT *
                    FROM expositores
                    WHERE cod_expositor='$cod_expositor'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;        
    case 3://baja
        $consulta= "DELETE FROM expositores 
                    WHERE cod_expositor ='$cod_expositor'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT *
                    FROM expositores 
                    WHERE cod_expositor='$cod_expositor'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 4://ver foto
        $consulta= "SELECT foto_expositor 
                    FROM expositores 
                    WHERE cod_expositor='$cod_expositor'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 5://subir foto
        if (isset($_FILES['foto_expositor']) && $_FILES['foto_expositor']['size'] > 0) {
            $foto_expositor = $_FILES["foto_expositor"];
            $archivoFoto_expositor = $_FILES["foto_expositor"]["tmp_name"];
            $informacionImagen = getimagesize($archivoFoto_expositor);
                if ($informacionImagen !== false && ($informacionImagen['mime'] == 'image/jpeg' || $informacionImagen['mime'] == 'image/png')) {
                    $ruta_destino_foto = '../img/expositores/';
                    $nombre_archivo_foto = $foto_expositor["name"];
                    $ubicacion_temporal_foto = $foto_expositor["tmp_name"];
                    $ruta_completa_foto = $ruta_destino_foto . $nombre_archivo_foto;
                    if (move_uploaded_file($ubicacion_temporal_foto, $ruta_completa_foto)) {
                        $foto_expositor = $nombre_archivo_foto;
                        $consulta= "UPDATE expositores SET foto_expositor = '$foto_expositor'
                                    WHERE cod_expositor = '$cod_expositor'";
                        $resultado = mysqli_query($conexion,$consulta);
            
                        $consulta= "SELECT foto_expositor FROM expositores 
                                    WHERE cod_expositor='$cod_expositor'";
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