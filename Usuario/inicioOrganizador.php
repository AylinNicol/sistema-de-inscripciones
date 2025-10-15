<?php
include "../Modelos/conexion.php";
/*INICIO SESION BIENVENIDO*/
session_start();
$cuenta = $_SESSION["s_usuario"];
$nombres_usuario = $_SESSION["s_nombres_usuario"];
$apellidos_usuario = $_SESSION["s_apellidos_usuario"];
//para ver si es organizador o si es administrativo
$consulta= "SELECT * FROM organizadores o, usuarios u WHERE u.cod_usuario = o.cod_usuario AND cuenta = '$cuenta'";
$resultado = mysqli_query($conexion,$consulta);
if(!empty($resultado) AND mysqli_num_rows($resultado) >= 1){
    $cuentaa = $cuenta;
}else{
    $cuentaa = "";
}
//Si nadie inció sesión vuelve a la pag de Login
if ($_SESSION["s_usuario"] == null){
	header("Location: ../InicioSesion.php");
}else{
    if($_SESSION["s_usuario"] != $cuentaa){
        header("Location: ./inicioAdministrativo.php");
    }
}
?>
<!DOCTYPE html>
<html bsUserlang=
<head>  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcur icon" href="#">
      
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="./css/baseUsuarios.css">
    <link rel="stylesheet" href="./css/inicioUsuario.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <title>Eventos Académicos</title>
    <link rel="icon" href="../img/LOGO.png">
</head>
<body>
    <!--MENU-->
    <?php require "../Vistas/MenuOrganizador.php"?>
    <!--BIENVENIDO-->
    <div class="Bienvenido">
        <h1 class="text-center">¡BIENVENIDO AL SISTEMA!</h1>
        <h2 class="text-center">Usuario: <span class="badge badge-info"><?php echo $nombres_usuario, " ", $apellidos_usuario;?></span></h2>
        <hr class="my-3"> 
    </div>
    <!-- HEADER -->
    <header class="main-header">
        <div class="background-overlay text-white py-5">
            <div class="contenedor">
                <div class="row d-flex h-100">
                    <div class="col-sm-8 text-center justify-content-center align-self-center">
                        <h2>
                            ¡Empieza a gestionar y generar la información hoy mismo!
                        </h2>
                        <p> Este sistema te permite organizar, almacenar y acceder a la información de forma eficiente. <br>
                            Accede al sistema desde cualquier ordenador con conexión a Internet.<br>
                            Para más información presiona...
                            </p>
                        <a href="ayudaOrganizador.php" class="btn">
                            LEER MÁS...
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <img src="../img/LOGO.png" class="img-fluid d-none d-sm-block">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ABOUT -->
    <section>
      <div class="contenedor">
        <div class="row text-center">
          <div class="col ml-auto">
            <h3>¿Cómo empezar?</h3>
            <p>Desplaza el puntero en el menú ubicado en la sección izquierda. Comienza a organizar y almacenar la información.</p>
            <h3>¿Necesitas ayuda?</h3>
            <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
          </div>
        </div>
      </div>
    </section>
    <footer>
      <div class="contenedor">
        <div class="row text-center text-white">
          <div class="col ml-auto">
            <p>Copyright &copy; 2023 Eventos Academicos. Todos los derechos reservados. <br>
            Política de privacidad Términos y condiciones.</p>
          </div>
        </div>
      </div>       
    </footer>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>