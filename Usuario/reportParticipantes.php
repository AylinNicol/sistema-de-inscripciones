    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorReportes.php";
    $consulta="SELECT ci, nombres_participante, apellidos_participante, celular, institucion, COUNT(cod_inscripcion) AS cantidad
                FROM participantes p, inscripciones i
                WHERE p.cod_participante = i.cod_participante
                GROUP BY p.cod_participante
                ORDER BY apellidos_participante";
    $resultado = mysqli_query($conexion,$consulta);
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>REPORTE GENERAL DE PARTICIPANTES</h1>
    </header>
    <!--................................-->
    
    <h4 class="text-right">Usuario: <span class="badge badge-info"><?php echo $nombres_usuario, " ", $apellidos_usuario;?></span></h4>
      
    <div class="Reporte">
        <div class="row">
            <div class="col-lg-12">
            <button id="BtnGenerarParticipantes" type="button" class="btn btn-success"><i class="fas fa-file-pdf"></i> GENERAR REPORTE</button>
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
                                    <th>Apellidos</th>
                                    <th>Nombres</th>
                                    <th>C.I.</th>
                                    <th>Celular</th>
                                    <th>Carrera o Institución</th>
                                    <th>Cantidad Eventos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach($data as $dat) {
                                ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $dat['apellidos_participante'] ?></td>
                                    <td><?php echo $dat['nombres_participante'] ?></td>
                                    <td><?php echo $dat['ci'] ?></td>
                                    <td><?php echo $dat['celular'] ?></td>
                                    <td><?php echo $dat['institucion'] ?></td>
                                    <td><?php echo $dat['cantidad'] ?></td>
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
