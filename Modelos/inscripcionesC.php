<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$nombres_participante = (isset($_POST['nombres_participante'])) ? $_POST['nombres_participante'] : '';
$apellidos_participante = (isset($_POST['apellidos_participante'])) ? $_POST['apellidos_participante'] : '';
$celular = (isset($_POST['celular'])) ? $_POST['celular'] : '';
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';
$nombre_evento = (isset($_POST['nombre_evento'])) ? $_POST['nombre_evento'] : '';
$institucion = (isset($_POST['institucion'])) ? $_POST['institucion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$ci = (isset($_POST['ci'])) ? $_POST['ci'] : '';
switch($opcion){
    case 1: //inscribe
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

        if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
            $dat = $resultado->fetch_assoc();
            $cod_participante = $dat['cod_participante'];

            $consulta= "SELECT * 
                        FROM inscripciones 
                        WHERE cod_participante ='$cod_participante' AND cod_evento ='$cod_evento'";
            $resultado = mysqli_query($conexion,$consulta);
            if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
                $data = null;
            }else{
                $consulta= "INSERT INTO inscripciones (cod_evento, cod_participante, fecha_inscripcion, pago, promocion) 
                            VALUES ('$cod_evento', '$cod_participante', CURDATE(), 'NO', '0')";
                $resultado = mysqli_query($conexion,$consulta);
                
                $consulta= "SELECT * 
                            FROM inscripciones i, eventos e, participantes p 
                            WHERE i.cod_evento=e.cod_evento AND i.cod_participante=p.cod_participante 
                            ORDER BY cod_inscripcion 
                            DESC LIMIT 1";
                $resultado = mysqli_query($conexion,$consulta);
                $data = $resultado->fetch_assoc();
            }
        }else{
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

            $consulta= "SELECT cod_participante 
                        FROM participantes 
                        ORDER BY cod_participante 
                        DESC LIMIT 1";
            $resultado = mysqli_query($conexion,$consulta);
            $dat = $resultado->fetch_assoc();
            $cod_participante = $dat['cod_participante'];

            $consulta= "INSERT INTO inscripciones (cod_evento, cod_participante, fecha_inscripcion, pago, promocion) 
                        VALUES ('$cod_evento', '$cod_participante', CURDATE(), 'NO', '0')";
            $resultado = mysqli_query($conexion,$consulta);
            
            $consulta= "SELECT * 
                        FROM inscripciones i, eventos e, participantes p 
                        WHERE i.cod_evento=e.cod_evento AND i.cod_participante=p.cod_participante 
                        ORDER BY cod_inscripcion 
                        DESC LIMIT 1";
            $resultado = mysqli_query($conexion,$consulta);
            $data = $resultado->fetch_assoc();
        }
        break;
    case 2: //mostrar
        $consulta= "SELECT * 
                    FROM participantes 
                    WHERE ci ='$ci'";
        $resultado = mysqli_query($conexion,$consulta);

        if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
            $data = $resultado->fetch_assoc();
        }else{
            $data=null;
        }
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>