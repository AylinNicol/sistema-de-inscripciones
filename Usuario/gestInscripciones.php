    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT cod_inscripcion, ci, nombre_evento, fecha_inscripcion, pago, promocion
                    FROM inscripciones i, eventos e, participantes p
                    WHERE i.cod_evento=e.cod_evento
                    AND i.cod_participante=p.cod_participante;";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>GESTIONAR INSCRIPCIONES</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>       
                    <table id="TablaInscripciones" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Código</th>
                                <th>C.I.</th>
                                <th>Evento</th>
                                <th>Fecha</th>
                                <th>Pago</th>
                                <th>Promoción %</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_inscripcion'] ?></td>
                                <td><?php echo $dat['ci'] ?></td>
                                <td><?php echo $dat['nombre_evento'] ?></td>
                                <td><?php echo $dat['fecha_inscripcion'] ?></td>
                                <td><?php echo $dat['pago'] ?></td>
                                <td><?php 
                                $prom=$dat['promocion']*100;
                                echo $prom ?></td>
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
                <form id="FormInscripciones">
                    <div class="modal-body">
                        <div>
                            <label for="ci" class="col-form-label">C.I.:</label>
                            <select class="form-select" aria-label="Default select example" id="ci">
                                <option selected>Seleccione un C.I.</option>
                                <?php
                                $consulta= "SELECT ci FROM participantes;";
                                $resultado = mysqli_query($conexion,$consulta);
                                $data = $resultado->fetch_all(MYSQLI_ASSOC);
                                foreach($data as $dat) {
                                ?>
                                <option value="<?php echo $dat['ci'] ?>"><?php echo $dat['ci'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="nombre_evento" class="col-form-label">Evento:</label>
                            <select class="form-select" aria-label="Default select example" id="nombre_evento">
                                <option selected>Seleccione un evento</option>
                                <?php
                                $consulta= "SELECT nombre_evento FROM eventos;";
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
                        <label for="pago" class="col-form-label">Pago:</label>
                        <input type="radio" name="pago" id="pago_SI" value="SI"> SI
                        <input type="radio" name="pago" id="pago_NO" value="NO"> NO
                        </div>
                        <div class="form-group">
                        <label for="promocion" class="col-form-label">Promoción(Ingrese el número de %):</label>
                        <input type="number" class="form-control" id="promocion" min="0" max="100" oninput="validarNumeros(this)">
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>
    <script type="text/javascript" src="./Controladores/gestInscripciones.js"></script>
</body>
</html>
