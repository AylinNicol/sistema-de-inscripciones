    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT * 
                    FROM usuarios u, administrativos a 
                    WHERE u.cod_usuario=a.cod_usuario";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>GESTIONAR ADMINISTRATIVOS</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>
                    <table id="TablaAdministrativos" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Cod.</th>
                                <th>C.I.</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Cuenta</th>
                                <th>Cargo</th>
                                <th>Correo Electrónico</th>
                                <th>Fecha Nacimiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_administrativo'] ?></td>
                                <td><?php echo $dat['ci_usuario'] ?></td>
                                <td><?php echo $dat['nombres_usuario'] ?></td>
                                <td><?php echo $dat['apellidos_usuario'] ?></td>
                                <td><?php echo $dat['cuenta'] ?></td>
                                <td><?php echo $dat['cargo'] ?></td>
                                <td><?php echo $dat['correo_usuario'] ?></td>
                                <td><?php echo $dat['fecha_nac'] ?></td>
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
                <form id="FormAdministrativos">
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
                        <input type="text" class="form-control" id="cuenta" minlength="3" maxlength="30" oninput="validarCaracteresEspeciales(this)">
                        </div>
                        <div class="form-group">
                        <label for="cargo" class="col-form-label">Cargo:</label>
                        <input type="text" class="form-control" id="cargo" minlength="3" maxlength="30" oninput="validarLetras(this)">
                        </div>
                        <div class="form-group">
                        <label for="correo_usuario" class="col-form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="correo_usuario" maxlength="50" onblur="validarCorreo(this)">
                        </div>
                        <div class="form-group">
                        <label for="fecha_nac" class="col-form-label">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="fecha_nac" max="<?= date('Y-m-d', strtotime('-15 years')); ?>" min="<?= date('Y-m-d', strtotime('-100 years')); ?>">
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
                        <label for="foto_usuario" class="col-form-label">Selecciona la foto del administrativo:</label>
                        <input type="file" class="form-control" id="foto_usuario" name="foto_usuario" accept="image/jpeg, image/png">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestAdministrativos.js"></script>
</body>
</html>
