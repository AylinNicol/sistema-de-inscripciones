    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT * FROM eventos";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    
    <!--TITULO-->
    <header>
        <h1>GESTIONAR EVENTOS</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>
                    <table id="TablaEventos" class="table table-striped table-bordered table-condensed dataTables" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Carrera</th>
                                <th>Costo</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Final</th>
                                <th>Material</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_evento'] ?></td>
                                <td><?php echo $dat['nombre_evento'] ?></td>
                                <td><?php echo $dat['tipo_evento'] ?></td>
                                <td><?php echo $dat['carrera'] ?></td>
                                <td><?php echo $dat['costo'] ?></td>
                                <td><?php echo $dat['fecha_inicio'] ?></td>
                                <td><?php echo $dat['fecha_fin'] ?></td>
                                <td><?php echo $dat['material'] ?></td>
                                <!--td></td>
                                <td><img src="../img/certificado/<?php //echo $dat['certificado'] ?>" width=100px></td-->
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
                <form id="FormEventos">    
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="nombre_evento" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre_evento" minlength="15" maxlength="100" oninput="validarLetrasyNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="tipo_evento" class="col-form-label">Tipo:</label>
                        <input type="text" class="form-control" id="tipo_evento" minlength="3" maxlength="25" oninput="validarLetras(this)">
                        </div>
                        <div>
                            <label for="carrera" class="col-form-label">Carrera:</label>
                            <select class="form-select" aria-label="Default select example" id="carrera">
                                <option selected>Seleccione una o ambas carreras</option>
                                <option value="Ingeniería de Sistemas">Ingeniería de Sistemas</option>
                                <option value="Ingeniería Informática">Ingeniería Informática</option>
                                <option value="Ingeniería de Sistemas e Ingeniería Informática">Ingeniería de Sistemas e Ingeniería Informática</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <label for="costo" class="col-form-label">Costo:</label>
                        <input type="number" class="form-control" id="costo" min="10" max="999" step="0.5" oninput="validarCosto(this)">
                        </div>
                        <div class="form-group">
                        <label for="fecha_inicio" class="col-form-label">Fecha de Inicio:</label>
                        <input type="date" class="form-control" id="fecha_inicio" max="<?= date('Y-m-d', strtotime('+10 years')); ?>" min="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group">
                        <label for="fecha_fin" class="col-form-label">Fecha de Final:</label>
                        <input type="date" class="form-control" id="fecha_fin" max="<?= date('Y-m-d', strtotime('+10 years')); ?>" min="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group">
                        <label for="material" class="col-form-label">Material:</label>
                        <input type="text" class="form-control" id="material" minlength="15" maxlength="100" oninput="validarLetrasyNumeros(this)">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--Modal para MAS-->
    <div class="modal fade" id="modalMAS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php require "../Vistas/SupModal.php";?>
                <div class="GestionarMas">
                    <div class="row">
                        <div class="col-lg-12">            
                        <button id="BtnNuevoMas" type="button" class="btn btn-success" data-toggle="modal"><i class="fas fa-plus"></i> NUEVO</button>    
                        </div>    
                    </div>    
                </div>    
                <br>  
                <div class="GestionarMas">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">        
                                <table id="TablaOrganizaciones" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Código</th>
                                            <th>Organizador</th>
                                            <th>Comision</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <!--Modal para CRUD MAS-->
    <div class="modal fade" id="modalCRUDMas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php require "../Vistas/SupModal.php";?>
                <form id="FormOrganizaciones">    
                    <div class="modal-body">
                        <div>
                            <label for="organizador" class="col-form-label">Organizador:</label>
                            <select class="form-select" aria-label="Default select example" id="organizador">
                                <option selected>Seleccione un organizador</option>
                                <?php
                                $consulta= "SELECT nombres_usuario, apellidos_usuario FROM organizadores o, usuarios u WHERE o.cod_usuario=u.cod_usuario;";
                                $resultado = mysqli_query($conexion,$consulta);
                                $data = $resultado->fetch_all(MYSQLI_ASSOC);
                                foreach($data as $dat) {
                                ?>
                                <option value="<?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?>"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="nombre" class="col-form-label">Comision:</label>
                            <select class="form-select" aria-label="Default select example" id="nombre">
                                <option selected>Seleccione una comision</option>
                                <?php
                                $consulta= "SELECT nombre FROM comisiones;";
                                $resultado = mysqli_query($conexion,$consulta);
                                $data = $resultado->fetch_all(MYSQLI_ASSOC);
                                foreach($data as $dat) {
                                ?>
                                <option value="<?php echo $dat['nombre'] ?>"><?php echo $dat['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    <!--Modal para POSTER-->
    <div class="modal fade" id="modalPoster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php require "../Vistas/SupModal.php";?>
                <div class="modal-image"></div>
                <form id="FormPoster">
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="poster" class="col-form-label">Selecciona la imagen de su poster:</label>
                        <input type="file" class="form-control" id="poster" name="poster" accept="image/jpeg, image/png">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    <!--Modal para CERTIFICADO-->
    <div class="modal fade" id="modalCertificado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php require "../Vistas/SupModal.php";?>
                <div class="modal-image"></div>
                <form id="FormCertificado">    
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="certificado" class="col-form-label">Selecciona la imagen de plantilla para el Certificado:</label>
                        <input type="file" class="form-control" id="certificado" name="certificado" accept="image/jpeg, image/png">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestEventos.js"></script>
    <script type="text/javascript" src="./Controladores/gestOrganizaciones.js"></script>
    
</body>
</html>
