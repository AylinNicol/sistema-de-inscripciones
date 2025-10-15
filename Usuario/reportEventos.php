    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorReportes.php";
    $consulta= "SELECT * FROM eventos";
    $resultado = mysqli_query($conexion,$consulta);
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>REPORTE GENERAL DE EVENTOS</h1>
    </header>
    <!--................................-->
    
    <h4 class="text-right">Usuario: <span class="badge badge-info"><?php echo $nombres_usuario, " ", $apellidos_usuario;?></span></h4>

    <div class="Reporte">
        <div class="row">
            <div class="col-lg-12">
            <button id="BtnGenerarEventos" type="button" class="btn btn-success"><i class="fas fa-file-pdf"></i> GENERAR REPORTE</button>
            </div>    
        </div>
    </div>    
    <br>  
    <div class="Reporte">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="TablaEventos" class="table table-striped table-bordered table-condensed" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Carrera</th>
                                    <th>Costo</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Fecha de Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach($data as $dat) {
                                ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $dat['nombre_evento'] ?></td>
                                    <td><?php echo $dat['carrera'] ?></td>
                                    <td><?php echo $dat['costo'] ?></td>
                                    <td><?php echo $dat['fecha_inicio'] ?></td>
                                    <td><?php echo $dat['fecha_fin'] ?></td>
                                </tr>
                                <?php
                                    $i = $i+1;
                                }
                                ?>
                            </tbody>
                       </table>
                    </div>
                </div>
        </div>  
    </div>

    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorReportes.php"?>
    
</body>
</html>
