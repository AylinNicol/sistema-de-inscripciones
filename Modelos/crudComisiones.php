<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_comision = (isset($_POST['cod_comision'])) ? $_POST['cod_comision'] : '';
switch($opcion){
    case 1: //alta*/
        $consulta= "INSERT INTO comisiones (nombre, descripcion) 
                    VALUES('$nombre', '$descripcion') ";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * 
                    FROM comisiones 
                    ORDER BY cod_comision 
                    DESC LIMIT 1";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 2: //modificación
        $consulta= "UPDATE comisiones SET nombre='$nombre', descripcion='$descripcion' 
                    WHERE cod_comision='$cod_comision' ";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT * 
                    FROM comisiones 
                    WHERE cod_comision='$cod_comision' ";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;        
    case 3://baja
        $consulta= "DELETE FROM comisiones 
                    WHERE cod_comision='$cod_comision' ";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT * FROM comisiones 
                    WHERE cod_comision='$cod_comision' ";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>