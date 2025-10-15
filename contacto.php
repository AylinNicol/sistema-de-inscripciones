<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="./css/bases.css">
    <link rel="stylesheet" href="./css/contacto.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="./img/LOGO.png">
</head>
<body>
    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!--MENU-->
    <?php require "Vistas/Menu.php"?>
    <!--RESTO-->
    <div class="general">
        <h1>CONTACTOS</h1>
        <p>Carrera Ingenieria de Sistemas - Ingenieria Informática</p>
        <p><i class="bi bi-geo-alt-fill"> </i>Pagador entre Ballivian y Aldana</p>
        <p><i class="bi bi-globe"> </i>www.sistemas.edu.bo</p>
        <p><i class="bi bi-telephone-fill"> </i>Telefonos:(591) 25276366</p>
        <p><i class="bi bi-envelope-fill"> </i>E-mail: informaciones@sistemas.edu.bo</p>
        <p><i class="bi bi-envelope-fill"> </i>E-mail: datacenter@sistemas.edu.bo</p>
        <p>Oruro-Bolivia</p>
    </div>
    <div class="general">
        <h1>¿EN QUE LE PODEMOS AYUDAR? </h1>
        <div class="preguntas">
            <section class="accordion-container">
                <h1 class="accordion-title">PREGUNTAS FRECUENTES</h1>
                <div class="accordion" id="accordionAyuda">
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="false" aria-controls="collapseOne">
                        <i class="bi bi-person-fill"></i>
                        <span class="accordion-label">INFORMACION DE EVENTOS Y EXPOSITORES</span>
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                      data-bs-parent="#accordionAyuda">
                      <div class="accordion-body">
                        <h2 class="accordion-subtitle">1. Como puedo conocer mas de los eventos?</h2>
                        <div class="accordion-text">Puedes dirigirte a la seccion de EVENTOS donde econtraras más informacion de
                          todos los eventos academicos disponibles y conocer mas de ellos.</div>
                        <h2 class="accordion-subtitle">2. Existe informacion mas detallada de cada evento?</h2>
                        <div class="accordion-text">Si, en las seccion de eventos puedes obtener informacion detallada de cada
                          uno de los
                          eventos academicos como la duracion, costo y programa de cada uno. </div>
                        <h2 class="accordion-subtitle">3. como puedo conocer quienes seran los expositores?</h2>
                        <div class="accordion-text">En la misma seccion de eventos exixte un boton de EXPOSITORES donde veras
                          informacion basica del expositos de cada evento.</div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                        aria-expanded="false" aria-controls="collapseTwo">
                        <i class="bi bi-file-text-fill"></i>
                        <span class="accordion-label">INSCRIPCION A EVENTOS ACADEMICOS</span>
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                      data-bs-parent="#accordionAyuda">
                      <div class="accordion-body">
                        <h2 class="accordion-subtitle"> 1. ¿COMO PUEDO INSCRIBIRME A LOS EVENTOS ACADEMICOS?</h2>
                        <div class="accordion-text">Dirigete a la seccion de INSCRIPCIONES, inmediatamente encontrarás el
                          formulario de inscripcion a eventos academicos.
                          <br>Llena todos los campos del formulario con tus datos y escoge el evento en el que deseas participar
                        </div>
                        <h2 class="accordion-subtitle">2. ¿PUEDO INSCRIBIRME EN UN EVENTO QUE YA SE ESTA LLEVANDO?</h2>
                        <div class="accordion-text">No, solo puedes inscribir a eventos disponibles que se llevaran acabo
                          posteriormente.</div>
                        <h2 class="accordion-subtitle">3. ¿Si ya me registre a un evento puedo volver a hacerlo?</h2>
                        <div class="accordion-text">No, el sistema no permite que puedas inscribirte mas de una vez a un mismo
                          evento, para evitar el duplicado de los datos y cantidad de participantes equivoco. </div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        <i class="bi bi-images"></i>
                        <span class="accordion-label">OBTENER CERTIFICADO</span>
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                      data-bs-parent="#accordionAyuda">
                      <div class="accordion-body">
                        <h2 class="accordion-subtitle">1. Quienes pueden obtener el certificado?</h2>
                        <div class="accordion-text">Todos los paticipantes inscritos en el evento que cancelaron su inscripcion.
                        </div>
                        <h2 class="accordion-subtitle">2. ¿Como puedo obtener mi certificado?</h2>
                        <div class="accordion-text">En el apartado de INICIO del menú podras explorar y encontrar el boton para
                          obtener tu certificado en formato digital.
                          <br>Si deseas ontener tu certificado de manera fisica puedes apersonarte a secretaria de la carrera de
                          Ingenieria de Sistemas e Ingenieria Informatica.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                        aria-expanded="false" aria-controls="collapseFour">
                        <i class="bi bi-currency-dollar"></i>
                        <span class="accordion-label">PAGO Y DESCUENTOS</span>
                      </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                      data-bs-parent="#accordionAyuda">
                      <div class="accordion-body">
                        <h2 class="accordion-subtitle">1. ¿Como consigo descuentos en mi inscripcion?</h2>
                        <div class="accordion-text">podras gozar de descuentos en algunos eventos academicos, si realizas tu
                          pago antes de la fecha limite</div>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                        aria-expanded="false" aria-controls="collapseSix">
                        <i class="bi bi-lock-fill"></i>
                        <span class="accordion-label">SEGURIDAD</span>
                      </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                      data-bs-parent="#accordionAyuda">
                      <div class="accordion-body">
                        <h2 class="accordion-subtitle">1. ¿Como se protege mis datos?</h2>
                        <div class="accordion-text">Existe seguridad atravez del encriptado de la contraseña</div>
                        <h2 class="accordion-subtitle">2. Quienes pueden ver todos mis datos?</h2>
                        <div class="accordion-text">Unicamentes personas autorizadas, es decir que cuenten con una cuenta de
                          usuario para ingresar a todos los registros como los organizadores del evento.</div>
                        <!-- Más preguntas y respuestas aquí -->
                      </div>
                    </div>
                  </div>
                </div>
            </section>
        </div>
    </div>
    <section class="contactos">
      <ul><li><a href="https://www.facebook.com/FNI.SisInf/"><i class="fab fa-facebook"></i></a></li></ul>
      <ul><li><a href="https://twitter.com/i/flow/login"><i class="fab fa-twitter"></i></a></li></ul>
      <ul><li><a href="https://www.instagram.com/accounts/login/"><i class="fab fa-instagram"></i></a></li></ul>
      <ul><li><a href="https://portal.sistemas.edu.bo/"><i class="bi bi-globe"></i></a></li></ul>
      <ul><li><a href="https://web.whatsapp.com/"><i class="fab fa-whatsapp"></i></a></li></ul>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="//code.tidio.co/xdv4ngm9okwredyttq9qwc11g0il83tg.js" async></script>
</body>
</html>