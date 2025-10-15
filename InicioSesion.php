<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
    <!--Alerts-->
    <link rel="stylesheet" href="./lib/plugins/sweet_alert2/sweetalert2.min.css">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="./css/bases.css">
    <link rel="stylesheet" href="./css/inicioSes.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="./img/LOGO.png">
</head>
<body>
    <!--FONDO MOVIMIENTO-->
    <div class='box'>
        <div class='wave -one'></div>
        <div class='wave -two'></div>
        <div class='wave -three'></div>
    </div>
    <!--MENU-->
    <?php require "Vistas/Menu.php"?>
    <div class="logoimagen"></div>
    <!--CONTENEDOR DE LOGIN-->
    <form id="FormLogin" method="post" action="" class="form">
        <div class="row mt-5">
            <div class="col-md-11"></div>
            <div class="col-md-1">
                <div class="loginForm">
                    <div class="login">
                        <label>INICIAR SESIÓN</label>
                    </div>
                    <div class="inputForm">
                        <div class="username">
                            <div class="FormUser">
                                <i class="fa-solid fa-user" style="color: #222d3f;"></i>
                                <input type="text" name="Usuario" id="Usuario" minlength="3" maxlength="30" oninput="validarCaracteresEspeciales(this)" placeholder="Usuario">
                            </div>
                        </div>
                        <div class="pass">
                            <div class="FormPass">
                                <i class="fa-solid fa-lock" style="color: #222d3f;"></i>
                                <input type="password" name="Password" id="Password" minlength="3" maxlength="50" oninput="validarCaracteresEspeciales(this)" placeholder="Contraseña">
                                <span class="toggle-password" onclick="togglePasswordVisibility('Password')">Mostrar</span>
                            </div>
                        </div>
                        <button id="BtnLogin" type="submit" name="submit">INGRESAR</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="./lib/jquery/jquery-3.3.1.min.js"></script>
    <script src="./lib/popper/popper.min.js"></script>
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
    <!--Alerts-->
    <script src="./lib/plugins/sweet_alert2/sweetalert2.all.min.js"></script>
    <!--JS prsonalizado-->
    <script type="text/javascript" src="./Controladores/InicioSesion.js"></script>
    <script type="text/javascript" src="./lib/parame.js"></script>

    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>
</html>