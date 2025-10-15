<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS
$cod_evento = (isset($_POST['cod_evento'])) ? $_POST['cod_evento'] : '';
$organizador = (isset($_POST['organizador'])) ? $_POST['organizador'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_detalle = (isset($_POST['cod_detalle'])) ? $_POST['cod_detalle'] : '';
switch($opcion){
    case 1: //alta*/
        $consulta= "SELECT cod_organizador 
                    FROM organizadores o, usuarios u 
                    WHERE o.cod_usuario=u.cod_usuario AND CONCAT(nombres_usuario, ' ', apellidos_usuario) ='$organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_organizador = $dat['cod_organizador'];

        $consulta= "SELECT cod_comision 
                    FROM comisiones 
                    WHERE nombre='$nombre'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_comision = $dat['cod_comision'];

        $consulta= "INSERT INTO detalles_eventos (cod_evento, cod_organizador, cod_comision) 
                    VALUES ('$cod_evento', '$cod_organizador', '$cod_comision')";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT cod_detalle, CONCAT(nombres_usuario, ' ', apellidos_usuario) AS organizador, nombre 
                    FROM detalles_eventos d, eventos e, organizadores o, usuarios u , comisiones c
                    WHERE d.cod_comision=c.cod_comision AND d.cod_organizador=o.cod_organizador AND o.cod_usuario=u.cod_usuario 
                    AND d.cod_evento=e.cod_evento AND d.cod_evento='$cod_evento'
                    ORDER BY cod_detalle DESC LIMIT 1";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 2: //modificación
        $consulta= "SELECT cod_organizador 
                    FROM organizadores o, usuarios u 
                    WHERE o.cod_usuario=u.cod_usuario AND CONCAT(nombres_usuario, ' ', apellidos_usuario) ='$organizador'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_organizador = $dat['cod_organizador'];

        $consulta= "SELECT cod_comision 
                    FROM comisiones 
                    WHERE nombre='$nombre'";
        $resultado = mysqli_query($conexion,$consulta);
        $dat = $resultado->fetch_assoc();
        $cod_comision = $dat['cod_comision'];

        $consulta= "UPDATE detalles_eventos SET cod_organizador='$cod_organizador', cod_comision='$cod_comision' 
                    WHERE cod_detalle='$cod_detalle'";
        $resultado = mysqli_query($conexion,$consulta);
        
        $consulta= "SELECT cod_detalle, CONCAT(nombres_usuario, ' ', apellidos_usuario) AS organizador, nombre 
                    FROM detalles_eventos d, eventos e, organizadores o, usuarios u , comisiones c
                    WHERE d.cod_comision=c.cod_comision AND d.cod_organizador=o.cod_organizador AND o.cod_usuario=u.cod_usuario 
                    AND d.cod_evento=e.cod_evento AND cod_detalle='$cod_detalle'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;   
    case 3://baja
        $consulta= "DELETE FROM detalles_eventos WHERE cod_detalle='$cod_detalle'";
        $resultado = mysqli_query($conexion,$consulta);

        $consulta= "SELECT cod_detalle, CONCAT(nombres_usuario, ' ', apellidos_usuario) AS organizador, nombre 
                    FROM detalles_eventos d, eventos e, organizadores o, usuarios u , comisiones c
                    WHERE d.cod_comision=c.cod_comision AND d.cod_organizador=o.cod_organizador AND o.cod_usuario=u.cod_usuario 
                    AND d.cod_evento=e.cod_evento AND cod_detalle='$cod_detalle'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
    case 4://mostrar
        $consulta= "SELECT cod_detalle, CONCAT(nombres_usuario, ' ', apellidos_usuario) AS organizador, nombre 
                    FROM detalles_eventos d, eventos e, organizadores o, usuarios u , comisiones c
                    WHERE d.cod_comision=c.cod_comision AND d.cod_organizador=o.cod_organizador AND o.cod_usuario=u.cod_usuario 
                    AND d.cod_evento=e.cod_evento AND d.cod_evento='$cod_evento'";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion->close();
?>