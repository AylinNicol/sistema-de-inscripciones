    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT * 
                    FROM participantes";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    
    <!--TITULO-->
    <header>
        <h1>GESTIONAR PARTICIPANTES</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>      
                    <table id="TablaParticipantes" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Código</th>
                                <th>C.I.</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                                <th>Carrera o Institución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_participante'] ?></td>
                                <td><?php echo $dat['ci'] ?></td>
                                <td><?php echo $dat['nombres_participante'] ?></td>
                                <td><?php echo $dat['apellidos_participante'] ?></td>
                                <td><?php echo $dat['celular'] ?></td>
                                <td><?php echo $dat['correo'] ?></td>
                                <td><?php echo $dat['institucion'] ?></td>
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
                <form id="FormParticipantes">    
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="ci" class="col-form-label">C.I.:</label>
                        <input type="number" class="form-control" id="ci" min="1000000" max="99999999" oninput="validarNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="nombres_participante" class="col-form-label">Nombres:</label>
                        <input type="text" class="form-control" id="nombres_participante" minlength="3" maxlength="45" oninput="convertirMayusculas(this)">
                        </div>
                        <div class="form-group">
                        <label for="apellidos_participante" class="col-form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos_participante" minlength="3" maxlength="45" oninput="convertirMayusculas(this)">
                        </div>
                        <div class="form-group">
                        <label for="celular" class="col-form-label">Celular:</label>
                        <input type="text" class="form-control" id="celular" pattern="^[67]\d{7}$" minlength="8" maxlength="8" oninput="validarNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="correo" class="col-form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="correo" id="correo" maxlength="30" onblur="validarCorreo(this)">
                        </div>
                        <div>
                            <label for="institucion" class="col-form-label">Carrera o Institución:</label>
                            <select class="form-select" aria-label="Default select example" id="institucion">
                                <option selected>Seleccione una carrera o institución</option>
                            </select>
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestParticipantess.js"></script>

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
