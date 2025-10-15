    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT * FROM expositores";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    
    <!--TITULO-->
    <header>
        <h1>GESTIONAR EXPOSITORES</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>       
                    <table id="TablaExpositores" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Código</th>
                                <th>C.I.</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                                <th>Nacionalidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_expositor'] ?></td>
                                <td><?php echo $dat['ci_expositor'] ?></td>
                                <td><?php echo $dat['nombres_expositor'] ?></td>
                                <td><?php echo $dat['apellidos_expositor'] ?></td>
                                <td><?php echo $dat['celular_expositor'] ?></td>
                                <td><?php echo $dat['correo_expositor'] ?></td>
                                <td><?php echo $dat['nacionalidad'] ?></td>
                                <td></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
    <?php require "../Vistas/InfTabla.php";?>
      
    <!--Modal para CRUD-->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php require "../Vistas/SupModal.php";?>
                <form id="FormExpositores">    
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="ci_expositor" class="col-form-label">C.I.:</label>
                        <input type="number" class="form-control" id="ci_expositor" min="1000000" max="99999999" oninput="validarNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="nombres_usuario" class="col-form-label">Nombres:</label>
                        <input type="text" class="form-control" id="nombres_expositor" minlength="3" maxlength="45" oninput="validarLetras(this)">
                        </div>
                        <div class="form-group">
                        <label for="apellidos_usuario" class="col-form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos_expositor" minlength="3" maxlength="45" oninput="validarLetras(this)">
                        </div>
                        <div class="form-group">
                        <label for="celular_expositor" class="col-form-label">Celular:</label>
                        <input type="text" class="form-control" id="celular_expositor" pattern="^[67]\d{7}$" minlength="8" maxlength="8" oninput="validarNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="correo_expositor" class="col-form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="correo_expositor" maxlength="30" onblur="validarCorreo(this)">
                        </div>
                        <div>
                            <label for="nacionalidad" class="col-form-label">Nacionalidad:</label>
                            <select class="form-select" aria-label="Default select example" id="nacionalidad">
                                <option selected>Seleccione una nacionalidad</option>
                            </select>
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--Modal para FOTO-->
    <div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php require "../Vistas/SupModal.php";?>
                <div class="modal-image"></div>
                <form id="FormFoto">
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="foto_expositor" class="col-form-label">Selecciona la foto del expositor:</label>
                        <input type="file" class="form-control" id="foto_expositor" name="foto_expositor" accept="image/jpeg, image/png">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>

    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestExpositores.js"></script>

    <script>
    const paises = [
        "Afganistán",
        "Albania",
        "Alemania",
        "Andorra",
        "Angola",
        "Antigua y Barbuda",
        "Arabia Saudita",
        "Argelia",
        "Argentina",
        "Armenia",
        "Australia",
        "Austria",
        "Azerbaiyán",
        "Bahamas",
        "Bangladés",
        "Barbados",
        "Baréin",
        "Bélgica",
        "Belice",
        "Benín",
        "Bielorrusia",
        "Birmania (Myanmar)",
        "Bolivia",
        "Bosnia y Herzegovina",
        "Botsuana",
        "Brasil",
        "Brunéi",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Bután",
        "Cabo Verde",
        "Camboya",
        "Camerún",
        "Canadá",
        "Catar",
        "Chad",
        "Chequia",
        "Chile",
        "China",
        "Chipre",
        "Colombia",
        "Comoras",
        "Corea del Norte",
        "Corea del Sur",
        "Costa de Marfil",
        "Costa Rica",
        "Croacia",
        "Cuba",
        "Dinamarca",
        "Dominica",
        "Ecuador",
        "Egipto",
        "El Salvador",
        "Emiratos Árabes Unidos",
        "Eritrea",
        "Eslovaquia",
        "Eslovenia",
        "España",
        "Estados Unidos",
        "Estonia",
        "Etiopía",
        "Filipinas",
        "Finlandia",
        "Fiyi",
        "Francia",
        "Gabón",
        "Gambia",
        "Georgia",
        "Ghana",
        "Granada",
        "Grecia",
        "Guatemala",
        "Guinea",
        "Guinea Ecuatorial",
        "Guinea-Bisáu",
        "Guyana",
        "Haití",
        "Honduras",
        "Hungría",
        "India",
        "Indonesia",
        "Irak",
        "Irán",
        "Irlanda",
        "Islandia",
        "Islas Marshall",
        "Islas Salomón",
        "Israel",
        "Italia",
        "Jamaica",
        "Japón",
        "Jordania",
        "Kazajistán",
        "Kenia",
        "Kirguistán",
        "Kiribati",
        "Kuwait",
        "Laos",
        "Lesoto",
        "Letonia",
        "Líbano",
        "Liberia",
        "Libia",
        "Liechtenstein",
        "Lituania",
        "Luxemburgo",
        "Macedonia del Norte",
        "Madagascar",
        "Malasia",
        "Malaui",
        "Maldivas",
        "Malí",
        "Malta",
        "Marruecos",
        "Mauricio",
        "Mauritania",
        "México",
        "Micronesia",
        "Moldavia",
        "Mónaco",
        "Mongolia",
        "Montenegro",
        "Mozambique",
        "Namibia",
        "Nauru",
        "Nepal",
        "Nicaragua",
        "Níger",
        "Nigeria",
        "Noruega",
        "Nueva Zelanda",
        "Omán",
        "Países Bajos",
        "Pakistán",
        "Palaos",
        "Panamá",
        "Papúa Nueva Guinea",
        "Paraguay",
        "Perú",
        "Polonia",
        "Portugal",
        "Reino Unido",
        "República Centroafricana",
        "República Checa",
        "República del Congo",
        "República Democrática del Congo",
        "República Dominicana",
        "Ruanda",
        "Rumania",
        "Rusia",
        "Samoa",
        "San Cristóbal y Nieves",
        "San Marino",
        "San Vicente y las Granadinas",
        "Santa Lucía",
        "Santo Tomé y Príncipe",
        "Senegal",
        "Serbia",
        "Seychelles",
        "Sierra Leona",
        "Singapur",
        "Siria",
        "Somalia",
        "Sri Lanka",
        "Sudáfrica",
        "Sudán",
        "Suecia",
        "Suiza",
        "Surinam",
        "Suazilandia",
        "Tailandia",
        "Tanzania",
        "Tayikistán",
        "Timor Oriental",
        "Togo",
        "Tonga",
        "Trinidad y Tobago",
        "Túnez",
        "Turkmenistán",
        "Turquía",
        "Tuvalu",
        "Ucrania",
        "Uganda",
        "Uruguay",
        "Uzbekistán",
        "Vanuatu",
        "Vaticano",
        "Venezuela",
        "Vietnam",
        "Yemen",
        "Yibuti",
        "Zambia",
        "Zimbabue"
    ];

    const nacionalidadSelect = document.getElementById("nacionalidad");

    paises.forEach(pais => {
        const option = document.createElement("option");
        option.value = pais;
        option.text = pais;
        nacionalidadSelect.appendChild(option);
    });
    </script>
</body>
</html>
