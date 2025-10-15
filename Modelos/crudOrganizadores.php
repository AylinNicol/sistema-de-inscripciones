<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$ci_usuario = (isset($_POST['ci_usuario'])) ? $_POST['ci_usuario'] : '';
$nombres_usuario = (isset($_POST['nombres_usuario'])) ? $_POST['nombres_usuario'] : '';
$apellidos_usuario = (isset($_POST['apellidos_usuario'])) ? $_POST['apellidos_usuario'] : '';
$cuenta = (isset($_POST['cuenta'])) ? $_POST['cuenta'] : '';
$contraseña = sha1('0');
$celular = (isset($_POST['celular'])) ? $_POST['celular'] : '';
$correo_usuario = (isset($_POST['correo_usuario'])) ? $_POST['correo_usuario'] : '';
$carrera = (isset($_POST['carrera'])) ? $_POST['carrera'] : '';
$rol = (isset($_POST['rol'])) ? $_POST['rol'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_organizador = (isset($_POST['cod_organizador'])) ? $_POST['cod_organizador'] : '';
switch($opcion){
    case 1: //alta*/
        $consulta= "SELECT * 
                    FROM usuarios 
                    WHERE ci_usuario = '$ci_usuario'";
        $resultado = mysqli_query($conexion,$consulta);
        if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
            $data = null;
        }else{
            $consulta= "INSERT INTO usuarios (cuenta, contraseña, ci_usuario, nombres_usuario, apellidos_usuario, correo_usuario) 
                        VALUES('$cuenta', '$contraseña', '$ci_usuario', '$nombres_usuario', '$apellidos_usuario', '$correo_usuario')";
            $resultado = mysqli_query($conexion,$consulta);
            
            $consulta= "SELECT cod_usuario 
                        FROM usuarios 
                        WHERE cuenta = '$cuenta'";
            $resultado = mysqli_query($conexion,$consulta);
            $dat = $resultado->fetch_assoc();
            $cod_usuario = $dat['cod_usuario'];

            $consulta= "INSERT INTO organizadores (celular, carrera, rol, cod_usuario) 
                        VALUES('$celular', '$carrera', '$rol', '$cod_usuario')";
            $resultado = mysqli_query($conexion,$consulta);

            $consulta= "SELECT * 
                        FROM usuarios u, organizadores a 
                        WHERE u.cod_usuario=a.cod_usuario ORDER BY cod_organizador DESC LIMIT 1";
            $resultado = mysqli_query($conexion,$consulta);
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
        }
        break;
    case 2: //modificación
        $consulta= "SELECT cod_usuario
                    FROM organizadores 
                    WHERE cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];

        $consulta= "UPDATE usuarios SET cuenta = '$cuenta',/* contraseña = md5('$contraseña'),*/ci_usuario = '$ci_usuario', nombres_usuario = '$nombres_usuario', apellidos_usuario = '$apellidos_usuario', correo_usuario = '$correo_usuario' 
                    WHERE cod_usuario = '$cod_usuario'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "UPDATE organizadores SET celular = '$celular', carrera = '$carrera', rol = '$rol' 
                    WHERE cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT * 
                    FROM usuarios u, organizadores a 
                    WHERE u.cod_usuario=a.cod_usuario AND cod_organizador='$cod_organizador' ";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;        
    case 3://baja
        $consulta= "SELECT cod_usuario 
                    FROM organizadores 
                    WHERE cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];

        $consulta= "DELETE FROM organizadores 
                    WHERE cod_organizador='$cod_organizador' ";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "DELETE FROM usuarios 
                    WHERE cod_usuario ='$cod_usuario'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * 
                    FROM usuarios u, organizadores a 
                    WHERE u.cod_usuario=a.cod_usuario AND cod_organizador='$cod_organizador' ";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 4://ver foto
        $consulta= "SELECT cod_usuario 
                    FROM organizadores 
                    WHERE cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];

        $consulta= "SELECT foto_usuario 
                    FROM usuarios 
                    WHERE cod_usuario='$cod_usuario'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 5://subir foto
        if (isset($_FILES['foto_usuario']) && $_FILES['foto_usuario']['size'] > 0) {
            $foto_usuario = $_FILES["foto_usuario"];
            $archivoFoto_usuario = $_FILES["foto_usuario"]["tmp_name"];
            $informacionImagen = getimagesize($archivoFoto_usuario);
                if ($informacionImagen !== false && ($informacionImagen['mime'] == 'image/jpeg' || $informacionImagen['mime'] == 'image/png')) {
                    $ruta_destino_foto = '../img/usuarios/';
                    $nombre_archivo_foto = $foto_usuario["name"];
                    $ubicacion_temporal_foto = $foto_usuario["tmp_name"];
                    $ruta_completa_foto = $ruta_destino_foto . $nombre_archivo_foto;
                    if (move_uploaded_file($ubicacion_temporal_foto, $ruta_completa_foto)) {
                        $foto_usuario = $nombre_archivo_foto;

                        $consulta= "SELECT cod_usuario 
                                    FROM organizadores 
                                    WHERE cod_organizador = '$cod_organizador'";
                        $resultado = mysqli_query($conexion,$consulta);
                        $dat = $resultado->fetch_assoc();
                        $cod_usuario = $dat['cod_usuario'];

                        $consulta= "UPDATE usuarios SET foto_usuario = '$foto_usuario' 
                                    WHERE cod_usuario = '$cod_usuario'";
                        $resultado = mysqli_query($conexion,$consulta);
            
                        $consulta= "SELECT foto_usuario 
                                    FROM usuarios 
                                    WHERE cod_usuario='$cod_usuario'";
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