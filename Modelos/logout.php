<?php
session_start();
unset($_SESSION["s_usuario"]);
unset($_SESSION["s_nombres_usuario"]);
unset($_SESSION["s_apellidos_usuario"]);
session_destroy();
header("Location: ../InicioSesion.php");
?>
