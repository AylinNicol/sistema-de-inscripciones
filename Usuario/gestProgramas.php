    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT cod_programa, nombre_evento, tema, hora_inicio, hora_fin, fecha, nombres_expositor, apellidos_expositor 
                    FROM programas p, eventos e, expositores ex 
                    WHERE p.cod_evento=e.cod_evento AND p.cod_expositor=ex.cod_expositor;";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>GESTIONAR PROGRAMAS</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>
                    <table id="TablaProgramas" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Código</th>
                                <th>Evento</th>
                                <th>Tema</th>
                                <th>Hora de Inicio</th>
                                <th>Hora Fin</th>
                                <th>Fecha</th>
                                <th>Expositor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_programa'] ?></td>
                                <td><?php echo $dat['nombre_evento'] ?></td>
                                <td><?php echo $dat['tema'] ?></td>
                                <td><?php echo $dat['hora_inicio'] ?></td>
                                <td><?php echo $dat['hora_fin'] ?></td>
                                <td><?php echo $dat['fecha'] ?></td>
                                <td><?php echo $dat['nombres_expositor']," ",$dat['apellidos_expositor'] ?></td>
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
                <form id="FormProgramas">
                    <div class="modal-body">
                        <div>
                            <label for="nombre_evento" class="col-form-label">Evento:</label>
                            <select class="form-select" aria-label="Default select example" id="nombre_evento">
                                <option selected>Seleccione un evento</option>
                                <?php
                                $consulta= "SELECT cod_evento, nombre_evento FROM eventos;";
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
                        <div class="form-group">
                        <label for="tema" class="col-form-label">Tema:</label>
                        <input type="text" class="form-control" id="tema" minlength="15" maxlength="100" oninput="validarLetrasyNumeros(this)">
                        </div>
                        <div class="form-group">
                        <label for="hora_inicio" class="col-form-label">Hora de Inicio:</label>
                        <input type="time" class="form-control" id="hora_inicio" min="08:30" max="18:00">
                        </div>
                        <div class="form-group">
                        <label for="hora_fin" class="col-form-label">Hora Fin:</label>
                        <input type="time" class="form-control" id="hora_fin" min="09:30" max="19:00">
                        </div>
                        <div class="form-group">
                        <label for="fecha" class="col-form-label">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" min="<?= date('Y-m-d'); ?>">
                        </div>
                        <div>
                            <label for="expositor" class="col-form-label">Expositor:</label>
                            <select class="form-select" aria-label="Default select example" id="expositor">
                                <option selected>Seleccione un expositor</option>
                                <?php
                                $consulta= "SELECT cod_expositor, nombres_expositor, apellidos_expositor FROM expositores;";
                                $resultado = mysqli_query($conexion,$consulta);
                                $data = $resultado->fetch_all(MYSQLI_ASSOC);
                                foreach($data as $dat) {
                                ?>
                                <option value="<?php echo $dat['nombres_expositor']," ",$dat['apellidos_expositor'] ?>"><?php echo $dat['nombres_expositor']," ",$dat['apellidos_expositor'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestProgramas.js"></script>  
    
</body>
</html>
