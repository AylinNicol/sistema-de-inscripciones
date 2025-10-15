<?php
    include "../Modelos/conexion.php";
    session_start();
    $cuenta = $_SESSION["s_usuario"];
    $nombres_usuario = $_SESSION["s_nombres_usuario"];
    $apellidos_usuario = $_SESSION["s_apellidos_usuario"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcur icon" href="#">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="../lib/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="../lib/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <!--Alerts-->
    <link rel="stylesheet" href="../lib/plugins/sweet_alert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="./css/baseUsuarios.css">
    <link rel="stylesheet" href="./css/cruds.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="../img/LOGO.png">
</head>
<body>
    <!--MENU-->
    <?php require "../Vistas/MenuOrganizador.php"?>