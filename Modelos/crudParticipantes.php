<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$ci = (isset($_POST['ci'])) ? $_POST['ci'] : '';
$nombres_participante = (isset($_POST['nombres_participante'])) ? $_POST['nombres_participante'] : '';
$apellidos_participante = (isset($_POST['apellidos_participante'])) ? $_POST['apellidos_participante'] : '';
$celular = (isset($_POST['celular'])) ? $_POST['celular'] : '';
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
$institucion = (isset($_POST['institucion'])) ? $_POST['institucion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_participante = (isset($_POST['cod_participante'])) ? $_POST['cod_participante'] : '';
switch($opcion){
    case 1: //alta*/
        if($celular == "0" && $correo == "-"){
            $consulta= "INSERT INTO participantes (ci, nombres_participante, apellidos_participante, institucion) 
                        VALUES ('$ci', '$nombres_participante', '$apellidos_participante', '$institucion')";
        }else if($celular == "0"){
            $consulta= "INSERT INTO participantes (ci, nombres_participante, apellidos_participante, correo, institucion) 
                        VALUES ('$ci', '$nombres_participante', '$apellidos_participante', '$correo', '$institucion')";
        }else if($correo == "-"){
            $consulta= "INSERT INTO participantes (ci, nombres_participante, apellidos_participante, celular, institucion) 
                        VALUES ('$ci', '$nombres_participante', '$apellidos_participante', '$celular', '$institucion')";
        }else{
            $consulta= "INSERT INTO participantes (ci, nombres_participante, apellidos_participante, celular, correo, institucion) 
                        VALUES ('$ci', '$nombres_participante', '$apellidos_participante', '$celular', '$correo', '$institucion')";
        }
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * 
                    FROM participantes 
                    ORDER BY cod_participante 
                    DESC LIMIT 1";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 2: //modificación
        if($celular == "0" && $correo == "-"){
            $consulta= "UPDATE participantes SET ci='$ci', nombres_participante='$nombres_participante', apellidos_participante='$apellidos_participante', celular=null, correo=null, institucion='$institucion'
                        WHERE cod_participante='$cod_participante'";
        }else if($celular == "0"){
            $consulta= "UPDATE participantes SET ci='$ci', nombres_participante='$nombres_participante', apellidos_participante='$apellidos_participante', celular=null, correo='$correo', institucion='$institucion'
                        WHERE cod_participante='$cod_participante'";
        }else if($correo == "-"){
            $consulta= "UPDATE participantes SET ci='$ci', nombres_participante='$nombres_participante', apellidos_participante='$apellidos_participante', celular='$celular', correo=null, institucion='$institucion'
                        WHERE cod_participante='$cod_participante'";
        }else{
            $consulta= "UPDATE participantes SET ci='$ci', nombres_participante='$nombres_participante', apellidos_participante='$apellidos_participante', celular='$celular', correo='$correo', institucion='$institucion'
                        WHERE cod_participante='$cod_participante'";
        }
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT * 
                    FROM participantes 
                    WHERE cod_participante='$cod_participante'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;        
    case 3://baja
        $consulta= "DELETE FROM participantes 
                    WHERE cod_participante='$cod_participante'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * FROM participantes 
                    WHERE cod_participante='$cod_participante'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>