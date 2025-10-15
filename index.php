<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- CSS personalizado -->    
    <link rel="stylesheet" href="./css/bases.css">
    <link rel="stylesheet" href="./css/inicio.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="./img/LOGO.png">
</head>
<body>
    <!--FONDO>
    <svg class="fondo_base"></svg-->
    <!--MENU-->
    <?php require "Vistas/Menu.php"?>
    <!--CARRUSEL-->
    <div id="CarouselE" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#CarouselE" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#CarouselE" data-bs-slide-to="1" aria-current="true"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#CarouselE" data-bs-slide-to="2" aria-current="true"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item  active">
                <img src="img/img6.png" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h3>BIENVENIDOS</h3>
                    <p>"Bienvenido/a al portal de inscripciones de eventos académicos la carrera de Ingenieria de
                        Sistemas e Informatica.</p>
                    <p> Estamos emocionados de que estés aquí para explorar y participar en nuestras actividades
                        académicas y eventos de alto nivel.</p>
                    <a href="./eventos.php" class="btn mt-3">VER EVENTOS</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/img1.jpeg" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h3>Sobre los eventos</h3>
                    <p> Te invitamos a explorar los eventos disponibles y registrarte en aquellos que más te interesen.
                    </p>
                    <p>Nuestra seccion de eventos ofrece oportunidades únicas para expandir tus conocimientos
                        Aquí encontrarás una amplia variedad de oportunidades para enriquecer tu experiencia académica.
                    </p>
                    <a href="./inscripciones.php" class="btn mt-3">INSCRIBIRSE</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/img3.png" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h1>¡Adelante, comienza tu viaje académico con nosotros!</h1>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#CarouselE" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#CarouselE" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    <!--LUGAR-->    
    <section class="about section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="img/lugar.jpg" style="margin-top: 15px" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text texto-info">
                        <h2> LUGAR DE LOS EVENTOS </h2>
                        <p>Todos los eventos se realizarán en la sala de conferencias de la Carrera de Ingenieria De
                            Sistemas e Informatica ubicada en la ciudadela universitaria en la zona sud del departamento de Oruro. Te
                            proporcinamos la ubicación para que llegues al lugar. </p></b>
                        <a href="https://maps.app.goo.gl/kN43n9deZC3sMRVQ6" class="btn espaciado">
                            <img src="img/ubi.png" width="auto" height="30" alt="" style="margin-right: 15px">VER UBICACIÓN
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text texto-info">
                        <h2> OBTÉN BENEFICIOS Y DESCUENTOS </h2>
                        <p>Si realizas el pago de inscripción en fechas de preventa o antes de la fecha en la que
                            finaliza las inscripciones para el evento que te registraste podrás obtener descuentos en tu
                            pago.</p></b>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="img/desc.gif" style="margin-top: 10px" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="img/certi.jpg" style="margin-top: 30px" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text texto-info">
                        <h2> OBTEN TU CERTIFICADO </h2>
                        <p>Si ya realizaste el pago de tu inscripcion puedes obtener tu certificado de participacion
                            aqui y descargarlo</p></b>
                        <button type="button" class="btn espaciado BtnCertificado" name="BtnCertificado" id="BtnCertificado">
                            <img src="img/icono_cer.png" width="auto" height="30" alt="" style="margin-right: 15px">OBTENER CERTIFICADO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--PIE-->
    <footer class="pie">
        <div class="header">
            <div class="logo">
                <img src="img/logo.png" alt="" class="img-logo">
                <p class="logotipo">Ingenieria De Sistemas e Informatica</p>
            </div>
            <div class="redes">
                <a href="https://www.facebook.com/tupagina" class="fb" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://twitter.com/tucuenta" class="tw" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                <a href="https://www.instagram.com/tuinstagram" class="in" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.linkedin.com/in/tuperfil" class="li" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://www.youtube.com/tucanal" class="yt" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
        <div class="derechos">
            <p>Copyright &copy; 2023 Eventos Academicos. Todos los derechos reservados. <br>
            Política de privacidad Términos y condiciones.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="./lib/jquery/jquery-3.3.1.min.js"></script>
    <script src="./lib/popper/popper.min.js"></script>
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
    <!--Alerts-->  
    <script src="./lib/plugins/sweet_alert2/sweetalert2.all.min.js"></script>
    <!-- JS personalizado -->
    <script type="text/javascript" src="./Controladores/inicio.js"></script>
    <script type="text/javascript" src="./lib/parame.js"></script>
</body>
</html>