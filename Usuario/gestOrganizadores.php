    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT * 
                    FROM usuarios u, organizadores o 
                    WHERE u.cod_usuario=o.cod_usuario";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    
    <!--TITULO-->
    <header>
        <h1>GESTIONAR ORGANIZADORES</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>      
                    <table id="TablaOrganizadores" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Cod.</th>
                                <th>C.I.</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Cuenta</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                                <th>Carrera</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_organizador'] ?></td>
                                <td><?php echo $dat['ci_usuario'] ?></td>
                                <td><?php echo $dat['nombres_usuario'] ?></td>
                                <td><?php echo $dat['apellidos_usuario'] ?></td>
                                <td><?php echo $dat['cuenta'] ?></td>
                                <td><?php echo $dat['celular'] ?></td>
                                <td><?php echo $dat['correo_usuario'] ?></td>
                                <td><?php echo $dat['carrera'] ?></td>
                                <td><?php echo $dat['rol'] ?></td>
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
                <form id="FormOrganizadores">    
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="ci_usuario" class="col-form-label">C.I.:</label>
                        <input type="number" class="form-control" id="ci_usuario" min="1000000" max="99999999" oninput="validarNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="nombres_usuario" class="col-form-label">Nombres:</label>
                        <input type="text" class="form-control" id="nombres_usuario" minlength="3" maxlength="45" oninput="validarLetras(this)">
                        </div>
                        <div class="form-group">
                        <label for="apellidos_usuario" class="col-form-label">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos_usuario" minlength="3" maxlength="45" oninput="validarLetras(this)">
                        </div>
                        <div class="form-group">
                        <label for="cuenta" class="col-form-label">Cuenta:</label>
                        <input type="text" class="form-control" id="cuenta" minlength="3" maxlength="30"oninput="validarCaracteresEspeciales(this)">
                        </div>
                        <div class="form-group">
                        <label for="celular" class="col-form-label">Celular:</label>
                        <input type="text" class="form-control" id="celular" pattern="^[67]\d{7}$" minlength="8" maxlength="8" oninput="validarNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="correo_usuario" class="col-form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="correo_usuario" maxlength="50"  onblur="validarCorreo(this)">
                        </div>
                        <div>
                            <label for="carrera" class="col-form-label">Carrera:</label>
                            <select class="form-select" aria-label="Default select example" id="carrera">
                                <option selected>Seleccione una carrera</option>
                                <option value="Ingeniería de Sistemas">Ingeniería de Sistemas</option>
                                <option value="Ingeniería Informática">Ingeniería Informática</option>
                            </select>
                        </div>
                        <div>
                            <label for="rol" class="col-form-label">Rol:</label>
                            <select class="form-select" aria-label="Default select example" id="rol">
                                <option selected>Seleccione un rol</option>
                                <option value="Docente">Docente</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Estudiante">Estudiante</option>
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
                        <label for="foto_usuario" class="col-form-label">Selecciona la foto del organizador:</label>
                        <input type="file" class="form-control" id="foto_usuario" name="foto_usuario" accept="image/jpeg, image/png">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestOrganizadores.js"></script>
</body>
</html>
