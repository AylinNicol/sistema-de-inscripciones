<?php
//Conexion con la BdD
$host_name = 'localhost';
$user_name = 'root';
$password = '';
$database = 'eventos';
$conexion = mysqli_connect($host_name,$user_name,$password,$database);
if(mysqli_errno($conexion)) {
    echo "error al conectarme";
}else{
    //echo "me conecte a la BdD";
}
$acentos = $conexion -> query("SET NAMES 'utf8'");
?>