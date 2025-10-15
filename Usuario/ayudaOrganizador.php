<!DOCTYPE html>
<html bsUserlang=
<head>  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcur icon" href="#">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS personalizado --> 
    <link rel="stylesheet" href="./css/ayudas.css">
    <!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous"-->
    <link rel="stylesheet" href="./css/baseUsuarios.css">

    <title>Eventos Académicos</title>
    <link rel="icon" href="../img/LOGO.png">
</head>
<body> 

    <!--MENU-->
    <?php require "../Vistas/MenuOrganizador.php"?>
    <!--AYUDA-->
    <div class="ayuda">
        <h1>¿EN QUÉ LE PODEMOS AYUDAR? </h1>
      <div class="preguntas">
        <section class="accordion-container">
          <h1 class="accordion-title">PREGUNTAS FRECUENTES</h1>
          <div class="accordion" id="accordionAyuda">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                  aria-expanded="false" aria-controls="collapseOne">
                  <i class="bi bi-person-fill"></i>
                  <span class="accordion-label">INICIO DE SESIÓN Y CUENTA</span>
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionAyuda">
                <div class="accordion-body">
                  <h2 class="accordion-subtitle">1. ¿Cómo crear una nueva cuenta?</h2>
                  <div class="accordion-text">En la sección de GESTIONAR USUARIOS dependiendiendo si desea crear cuenta
                    para administrativo u organizador existe un botón para cada uno que le permitirá crear nuevas cuentas.</div>
                  <h2 class="accordion-subtitle">2. ¿Cómo puedo iniciar sesión como organizador?</h2>
                  <div class="accordion-text">El primer requisito es tener una cuenta de usuario donde se le asigna una
                    cuenta y contraseña. <br>Posteriormente debe ingresar los datos proporcionados en el logo de Iniciar Sesión 
                    de manera correcta y podrá iniciar sesión sin problemas. </div>
                  <h2 class="accordion-subtitle">3. ¿Cómo cambiar la información de alguna cuenta?</h2>
                  <div class="accordion-text">Si desea cambiar la información en algún campo, se tiene la opción de editar
                    información en la seccion de GESTIONAR USUARIOS luego selecciona ya sea administrativo u organizador.</div>
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                  aria-expanded="false" aria-controls="collapseTwo">
                  <i class="bi bi-file-text-fill"></i>
                  <span class="accordion-label">GESTIÓN DE DATOS</span>
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionAyuda">
                <div class="accordion-body">
                  <h2 class="accordion-subtitle">1. ¿Cómo agregar nuevos registros en las gestiones de datos?</h2>
                  <div class="accordion-text">Dirígete a la sección de GESTIONAR en la que deseas agregar, selecciona el botón
                    NUEVO, llena todos los campos que te pida , presiona Guardar y tendrás un nuevo registro. </div>
                  <h2 class="accordion-subtitle">2. ¿Cómo editar o borrar registros?</h2>
                  <div class="accordion-text">Cada registro cuenta con las opciones de EDITAR y BORRAR en la columna de
                    Acciones. <br>Por lo tanto puede realizar cualquiera de las acciones según sus necesidades.</div>
                  <h2 class="accordion-subtitle">3. ¿Cómo realizar búsquedas en los registros?</h2>
                  <div class="accordion-text">En cada gestión encontrarás la sección de Buscar donde podrás ingresar el dato
                    que desees y el mismo buscará el dato ingresado en cualquier columna de manera rapida. Además puede escribir 
                    sin importar mayúsculas o minúsculas.
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                  aria-expanded="false" aria-controls="collapseThree">
                  <i class="bi bi-file-pdf"></i>
                  <span class="accordion-label">GENERACIÓN DE DOCUMENTOS</span>
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#accordionAyuda">
                <div class="accordion-body">
                  <h2 class="accordion-subtitle">1. ¿Cómo puedo generar reportes?</h2>
                  <div class="accordion-text">En la sección REPORTES, podrá seleccionar la opción de la cual desea el reporte. 
                    Posteriormente podrá visualizar el reporte seleccionado, finalmente presione el botón GENERAR REPORTE el cual 
                    le abrirá una nueva pestaña con el reporte en formato PDF, lo cual podrá descargar o imprimir.</div>
                  <h2 class="accordion-subtitle">2. ¿Cómo puedo generar certificados?</h2>
                  <div class="accordion-text">En la sección GESTIONAR INSCRIPCIONES, en la columna Acciones. Seleccione CERTIFICADO, 
                      en caso de que el participante no haya realizado el pago no le permitirá generar el certificado, caso contrario 
                      se abrira una nueva pestaña con el certificado generado en formato PDF, lo cual podrá descargar o imprimir.</div>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                  aria-expanded="false" aria-controls="collapseFour">
                  <i class="bi bi-images"></i>
                  <span class="accordion-label">AÑADIR IMÁGENES</span>
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionAyuda">
                <div class="accordion-body">
                  <h2 class="accordion-subtitle">1. ¿Cómo puedo añadir imágenes?</h2>
                  <div class="accordion-text">En la columna de Acciones seleccionar el botón que dice FOTO, CERTIFICADO O POSTER; 
                    dependiendo en la gestión que se encuentre. <br>Seleccione la imagen correspondiente desde su ordenador. 
                    <br>TOME EN CUENTA: para CERTIFICADO seleccione una imagen que sea proporcional al tamaño de hoja Carta, para no 
                    tener inconvenientes al generar el certificado en GESTIONAR INSCRIPCIONES.</div>
                  <h2 class="accordion-subtitle">2. ¿En qué gestiones se tiene la opción de añadir imagen?</h2>
                  <div class="accordion-text">Se tiene esa opción en GESTIONAR ADMINISTRATIVOS, GESTIONAR ORGANIZADORES, GESTIONAR EVENTOS 
                    y GESTIONAR EXPOSITORES.</div>
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
                  <h2 class="accordion-subtitle">1. ¿Cómo puedo cambiar la contraseña de usuario?</h2>
                  <div class="accordion-text">En la sección GESTIONAR ADMINISTRATIVOS o GESTIONAR ORGANIZADORES, en la columna Acciones. 
                    Seleccione CAMBIAR CLAVE, debe ingresar la contraseña actual para luego ingresar la nueva contraseña.</div>
                  <h2 class="accordion-subtitle">2. ¿Cómo reestablezco mi contraseña?</h2>
                  <div class="accordion-text">En caso de olvidar la contraseña puede dirigirse a la sección GESTIONAR ADMINISTRATIVOS o 
                    GESTIONAR ORGANIZADORES, en la columna Acciones. Seleccione REESTABLECER CLAVE y la nueva contraseña será "000".</div>
                  <h2 class="accordion-subtitle">3. ¿Cómo se protege mi contraseña?</h2>
                  <div class="accordion-text">Existe seguridad a través del encriptado de la contraseña.</div>
                  <h2 class="accordion-subtitle">4. ¿Quiénes pueden ver todos los datos?</h2>
                  <div class="accordion-text">Únicamentes personas autorizadas, es decir, personas que cuenten con una cuenta de
                    usuario podrán ingresar a todos los registros.</div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <h1>SOPORTE TÉCNICO</h1>
      <div class="soporte">
        <h3>Contáctate de manera directa con el equipo de soporte tecnico</h3>
        <div class="data">
          <div class="row g-2">
            <div class="col " class="col1">
              <p><i class="fa solid fa-user"></i> Mamani Ala Mariana</p>
              <p><i class="fa solid fa-phone"></i> 60436071</p>
              <p><i class="fa solid fa-envelope"></i> mariana.mamani@sistemas.edu.bo</p>
            </div>
            <div class="col">
              <p><i class="fa solid fa-user"></i> Nina Hannover Aylin Nicol</p>
              <p><i class="fa solid fa-phone"></i> 76143902</p>
              <p><i class="fa solid fa-envelope"></i> aylin.nina@sistemas.edu.bo</p>
            </div>
            <div class="col">
              <p><i class="fa solid fa-user"></i> Porrez Zabala Samantha Zamira</p>
              <p><i class="fa solid fa-phone"></i> 69588700</p>
              <p><i class="fa solid fa-envelope"></i> samantha.porrez@sistemas.edu.bo</p>
            </div>
            <div class="col">
            </div>
          </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="//code.tidio.co/xdv4ngm9okwredyttq9qwc11g0il83tg.js" async></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"></script>
    
</body>
</html>