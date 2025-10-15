<?php
include "./Modelos/conexion.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--Alerts-->  
    <link rel="stylesheet" href="./lib/plugins/sweet_alert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="./css/bases.css">
    <link rel="stylesheet" href="./css/inscripcion.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="./img/LOGO.png">
</head>
<body id="barra">
    <!--FONDO MOVIMIENTO-->
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice" class="fondo_base">
        <defs>
            <linearGradient id="bg">
                <stop offset="0%" style="stop-color:rgba(3, 20, 77, 0.44)"></stop>
                <stop offset="50%" style="stop-color:rgba(93, 187, 245, 0.74)"></stop>
                <stop offset="100%" style="stop-color:rgba(76, 239, 166, 0.656)"></stop>
            </linearGradient>
            <path id="wave" fill="url(#bg)" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0 s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
        </defs>
        <g>
            <use xlink:href='#wave' opacity=".3">
                <animateTransform
                  attributeName="transform"
                  attributeType="XML"
                  type="translate"
                  dur="10s"
                  calcMode="spline"
                  values="270 230; -334 180; 270 230"
                  keyTimes="0; .5; 1"
                  keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                  repeatCount="indefinite" />
            </use>
            <use xlink:href='#wave' opacity=".6">
                <animateTransform
                  attributeName="transform"
                  attributeType="XML"
                  type="translate"
                  dur="8s"
                  calcMode="spline"
                  values="-270 230;243 220;-270 230"
                  keyTimes="0; .6; 1"
                  keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                  repeatCount="indefinite" />
            </use>
            <use xlink:href='#wave' opacty=".9">
                <animateTransform
                  attributeName="transform"
                  attributeType="XML"
                  type="translate"
                  dur="6s"
                  calcMode="spline"
                  values="0 230;-140 200;0 230"
                  keyTimes="0; .4; 1"
                  keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                  repeatCount="indefinite" />
            </use>
        </g>
    </svg>
    <!--MENU-->
    <?php require "Vistas/Menu.php"?>
    <!--FORMULARIO-->
    <section class="content">
        <div class="container">
            <div class="card bg-transparent ">
                <div class="card-header bg-transparent text-center text-light mx-auto" id="Titulo">
                    FORMULARIO DE INSCRIPCIÓN
                    <label class="form-label mt-0 mb-0 mx-auto" id="Mensaje">(Si realizó una inscripción anterior, busque sus datos ingresando su CI)</label>
                </div>
                <form id="FormInscripciones">
                    <div class="card-body" >
                        <div class="row mb-1 mt-0">
                            <div class="col-md-3">
                                <label for="ci" class="form-label">Carnet de Identidad</label>
                                <input type="number" class="form-control" id="ci" min="1000000" max="99999999" oninput="validarNumeros(this)" aria-describedby="ci" placeholder="Carnet de Identidad">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-transparent btn-lg text-center text-light mx-auto d-block my-2 BtnBuscar" name="BtnBuscar" id="BtnBuscar"><i class='fas fa-search'></i> BUSCAR</button>
                            </div>
                            <div class="col-md-7">
                                <label for="nombre_evento" class="form-label">Evento</label>
                                <select class="form-select" aria-label="Default select example" id="nombre_evento">
                                    <option selected>Seleccione un evento</option>
                                    <?php
                                    $consulta= "SELECT nombre_evento FROM eventos WHERE fecha_fin >= CURDATE() ORDER BY fecha_inicio;";
                                    $resultado = mysqli_query($conexion,$consulta);
                                    $data = $resultado->fetch_all(MYSQLI_ASSOC);
                                    foreach($data as $dat) {
                                    ?>
                                    <option value="<?php echo $dat['nombre_evento'] ?>"><?php echo $dat['nombre_evento'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1 mt-0">
                            <div class="col-md-6">
                                <label for="apellidos_participante" class="form-label">Apellidos</label>
                                <!--input class="form-control" id="apellidos_participante" type="text" placeholder="Perez" disabled-->
                                <input type="text" class="form-control" id="apellidos_participante" minlength="3" maxlength="45" oninput="convertirMayusculas(this)" aria-describedby="apellidos_participante" placeholder="Apellido Paterno">
                            </div>
                            <div class="col-md-6">
                                <label for="nombres_participante" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombres_participante" minlength="3" maxlength="45" oninput="convertirMayusculas(this)" aria-describedby="nombres_participante" placeholder="Nombres">
                            </div>
                        </div>
                        <div class="row mb-1 mt-0">
                            <div class="col-md-2">
                                <label for="celular" class="form-label">Celular</label>
                                <input type="text" class="form-control" id="celular" pattern="^[67]\d{7}$" minlength="8" maxlength="8" oninput="validarNumeros(this)" aria-describedby="celular" placeholder="Celular">
                            </div>
                            <div class="col-md-4">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" maxlength="30" onblur="validarCorreo(this)" aria-describedby="correo" placeholder="Correo Electrónico">
                            </div>
                            <div class="col-md-6">
                                <label for="institucion" class="form-label">Carrera o Institución a la que pertenece</label>
                                <select class="form-select" aria-label="Default select example" id="institucion">
                                    <option selected>Seleccione una carrera o institución</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-0 mt-0">                
                            <div class="col-md-9">
                                <label for="Pago" class="form-label">El pago para la inscripción incluye Certificado. (El pago debe ser realizado de forma física en secretaría)</label>
                                <label for="Pago" class="form-label" id="Mensaje">Si se inscribió anteriormente, la inscripción se realizará con los datos de la primera inscripción según el C.I. ingresado.</label>
                                <label for="Pago" class="form-label" id="Mensaje">Para cualquier modificación de datos pase por secretaria o contáctese con algún organizador.</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-transparent btn-lg text-end text-light ms-auto mb-5 mt-0" id="BtnInscribirse">INSCRIBIRSE</button>
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="./lib/jquery/jquery-3.3.1.min.js"></script>
    <script src="./lib/popper/popper.min.js"></script>
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
    <!--Alerts-->  
    <script src="./lib/plugins/sweet_alert2/sweetalert2.all.min.js"></script>
    <!--JS prsonalizado-->
    <script type="text/javascript" src="./Controladores/inscripcionsss.js"></script>
    <script type="text/javascript" src="./lib/parame.js"></script>

    <script>
    const instituciones = [
        "U.T.O. - F.N.I. - Ing. de Minas",
        "U.T.O. - F.N.I. - Ing. Civil",
        "U.T.O. - F.N.I. - Ing. Metalúrgica",
        "U.T.O. - F.N.I. - Ing. Mecánica",
        "U.T.O. - F.N.I. - Ing. Electromecánica",//38
        "U.T.O. - F.N.I. - Ing. Eléctrica",
        "U.T.O. - F.N.I. - Ing. Electrónica",
        "U.T.O. - F.N.I. - Ing. Química",
        "U.T.O. - F.N.I. - Ing. de Alimentos",
        "U.T.O. - F.N.I. - Ing. Geológica",
        "U.T.O. - F.N.I. - Ing. de Sistemas",
        "U.T.O. - F.N.I. - Ing. Informática",
        "U.T.O. - F.N.I. - Ing. Industrial"
    ];

    const institucionSelect = document.getElementById("institucion");

    instituciones.forEach(insti => {
        const option = document.createElement("option");
        option.value = insti;
        option.text = insti;
        institucionSelect.appendChild(option);
    });
    </script>

</body>
</html>