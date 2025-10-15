<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$password = sha1($password);
$cod_administrativo = (isset($_POST['cod_administrativo'])) ? $_POST['cod_administrativo'] : '';
$cod_organizador = (isset($_POST['cod_organizador'])) ? $_POST['cod_organizador'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
switch($opcion){
    case 1: //verificar administrativo
        $consulta= "SELECT *
                    FROM usuarios u, administrativos a 
                    WHERE u.cod_usuario=a.cod_usuario AND cod_administrativo = '$cod_administrativo'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cont = $dat['contraseña'];
        if($password == $cont){
            $data = $dat;
        }else{
            $data = null;
        }
        break;
    case 2: //modificación administrativo
        $consulta= "SELECT cod_usuario 
                    FROM administrativos 
                    WHERE cod_administrativo = '$cod_administrativo'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];

        $consulta= "UPDATE usuarios SET contraseña = '$password'
                    WHERE cod_usuario = '$cod_usuario'";
        $resultado = $conexion->query($consulta);

        $consulta= "SELECT cod_administrativo, nombres_usuario, apellidos_usuario, cuenta, contraseña, cargo, fecha_nac 
                    FROM usuarios u, administrativos a 
                    WHERE u.cod_usuario=a.cod_usuario AND cod_administrativo='$cod_administrativo'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break; 
    case 3: //verificar organizador
        $consulta= "SELECT *
                    FROM usuarios u, organizadores o 
                    WHERE u.cod_usuario=o.cod_usuario AND cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cont = $dat['contraseña'];
        if($password == $cont){
            $data = $dat;
        }else{
            $data = null;
        }
        break;
    case 4: //modificación organizador
        $consulta= "SELECT cod_usuario
                    FROM organizadores
                    WHERE cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];
        $consulta= "UPDATE usuarios SET contraseña = '$password'
                    WHERE cod_usuario = '$cod_usuario'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT cod_organizador, nombres_usuario, apellidos_usuario, cuenta, contraseña, celular, carrera, rol 
                    FROM usuarios u, organizadores o 
                    WHERE u.cod_usuario=o.cod_usuario AND cod_organizador='$cod_organizador' ";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 5: //reestablecer administrativo
        $consulta= "SELECT cod_usuario 
                    FROM administrativos 
                    WHERE cod_administrativo = '$cod_administrativo'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];

        $password = sha1('000');

        $consulta= "UPDATE usuarios SET contraseña = '$password'
                    WHERE cod_usuario = '$cod_usuario'";
        $resultado = $conexion->query($consulta);

        $consulta= "SELECT cod_administrativo, nombres_usuario, apellidos_usuario, cuenta, contraseña, cargo, fecha_nac 
                    FROM usuarios u, administrativos a 
                    WHERE u.cod_usuario=a.cod_usuario AND cod_administrativo='$cod_administrativo'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 6: //reestablecer organizador
        $consulta= "SELECT cod_usuario
                    FROM organizadores
                    WHERE cod_organizador = '$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_usuario = $dat['cod_usuario'];

        $password = sha1('000');

        $consulta= "UPDATE usuarios SET contraseña = '$password'
                    WHERE cod_usuario = '$cod_usuario'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT cod_organizador, nombres_usuario, apellidos_usuario, cuenta, contraseña, celular, carrera, rol 
                    FROM usuarios u, organizadores o 
                    WHERE u.cod_usuario=o.cod_usuario AND cod_organizador='$cod_organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break; 
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>