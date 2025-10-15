    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorReportes.php";
    $consulta ="SELECT e.cod_evento, nombre_evento, fecha_inicio, fecha_fin, COUNT(cod_inscripcion) AS cantidad, costo, SUM(costo-(costo*promocion)) AS subtotal
                FROM eventos e, inscripciones i
                WHERE e.cod_evento=i.cod_evento
                GROUP BY e.cod_evento;";
    $resultado = mysqli_query($conexion,$consulta);
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>CÁLCULO DE EVENTOS</h1>
    </header>
    <!--................................-->    
    <h4 class="text-right">Usuario: <span class="badge badge-info"><?php echo $nombres_usuario, " ", $apellidos_usuario;?></span></h4>
  
    <div class="Reporte">
        <div class="row">
            <div class="col-lg-12">
            <button id="BtnGenerarCalculoEventos" type="button" class="btn btn-success"><i class="fas fa-file-pdf"></i> GENERAR REPORTE</button>
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
                                    <th>Fechas</th>
                                    <th>Costo</th>
                                    <th>Cant. Ins.</th>
                                    <th>Subtotal</th>
                                    <th>Cant. Ins. Pagados</th>
                                    <th>Subtotal Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach($data as $dat) {
                                    $codigo = $dat['cod_evento'];
                                    $consulta="SELECT SUM(costo-(costo*promocion)) AS subtotalquehay, COUNT(cod_inscripcion) AS cant
                                                FROM eventos.eventos e, eventos.inscripciones i
                                                WHERE e.cod_evento = i.cod_evento AND pago = 'SI' AND e.cod_evento = '$codigo'
                                                GROUP BY e.cod_evento;";
                                    $resultado = mysqli_query($conexion,$consulta);
                                    $dato = $resultado->fetch_assoc();
                                    $cant = $dato['cant'];
                                    $sub_actual = $dato['subtotalquehay'];
                                    $sub_actual = round($sub_actual, 2);
                                    $subtotal = round($dat['subtotal'], 2);
                                ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $dat['nombre_evento'] ?></td>
                                    <td><?php echo $dat['fecha_inicio']," a ",$dat['fecha_fin']?></td>
                                    <td><?php echo $dat['costo']," Bs." ?></td>
                                    <td><?php echo $dat['cantidad'] ?></td>
                                    <td><?php echo $subtotal," Bs." ?></td>
                                    <td><?php echo $cant ?></td>
                                    <td><?php echo $sub_actual," Bs." ?></td>
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
