<?php
session_start();
include "conexion.php";
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$password = sha1($password);

//LIMPIEZA
$consulta="SELECT cod_inscripcion, cod_participante
            FROM inscripciones i, eventos e
            WHERE i.cod_evento = e.cod_evento AND pago = 'NO' AND fecha_inscripcion>fecha_inicio;";
$resultado = mysqli_query($conexion,$consulta);
$data = $resultado->fetch_all(MYSQLI_ASSOC);
foreach($data as $dat) {
    $cod_inscripcion = $dat['cod_inscripcion'];
    $cod_participante = $dat['cod_participante'];
    $consulta= "DELETE FROM inscripciones 
                WHERE cod_inscripcion = '$cod_inscripcion'";
    $resultado = mysqli_query($conexion,$consulta);
    $consulta= "SELECT cod_inscripcion, p.cod_participante
                FROM inscripciones i, participantes p
                WHERE i.cod_participante=p.cod_participante AND p.cod_participante = '$cod_participante';";
    $resultado = mysqli_query($conexion,$consulta);
    $numeroFilas = mysqli_num_rows($resultado);
    if ($numeroFilas == 0) {
        $consulta= "DELETE FROM participantes 
                    WHERE cod_participante = '$cod_participante'";
        $resultado = mysqli_query($conexion,$consulta);
    }
}

$consulta= "SELECT *
            FROM usuarios 
            WHERE cuenta = '$usuario'";
$resultado = mysqli_query($conexion,$consulta);

if(!empty($resultado) AND mysqli_num_rows($resultado) == 1){
    $data = $resultado->fetch_assoc();
    $pass = $data['contraseña'];
    if($pass == $password){
        $_SESSION["s_usuario"] = $usuario;
        $_SESSION["s_nombres_usuario"] = $data['nombres_usuario'];
        $_SESSION["s_apellidos_usuario"] = $data['apellidos_usuario'];
    }else{
        $_SESSION["s_usuario"] = null;
        $_SESSION["s_nombres_usuario"] = null;
        $_SESSION["s_apellidos_usuario"] = null;
        $data=null;
    }
}else{
    $_SESSION["s_usuario"] = null;
    $_SESSION["s_nombres_usuario"] = null;
    $_SESSION["s_apellidos_usuario"] = null;
    $data=null;
}
print json_encode($data);//envio el array final el formato json a AJAX
$conexion->close();
?>