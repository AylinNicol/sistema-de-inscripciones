<?php
include "conexion.php";
// Recepción de los datos enviados mediante POST desde el JS   
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$cod_evento = (isset($_POST['cod_evento'])) ? $_POST['cod_evento'] : '';
switch($opcion){
    case 1:
        ?>
        <div class="generales">
            <section class="contenido">
                <div class="Mostrador" id="Mostrador">
                    <?php
                    $consulta= "SELECT e.cod_expositor, foto_expositor, nombres_expositor, apellidos_expositor, nacionalidad, correo_expositor, celular_expositor
                                FROM programas p, expositores e 
                                WHERE p.cod_expositor=e.cod_expositor AND cod_evento='$cod_evento' 
                                GROUP BY e.cod_expositor";
                    $resultado = mysqli_query($conexion,$consulta);
                    $data = $resultado->fetch_all(MYSQLI_ASSOC);
                    if($data==null){?>
                        Aún no existen expositores.
                    <?php
                    }else{
                        foreach($data as $dat) {?>
                        <div class="fila">
                            <div class="item ">
                                <div class="foto">
                                    <img src="./img/expositores/<?php echo $dat['foto_expositor'] ?>" alt="" height="200px" width="200px">
                                    <p  class="descripcion">
                                    Nombres: <?php echo $dat['nombres_expositor']," ",$dat['apellidos_expositor'] ?><br>
                                    Nacionalidad: <?php echo $dat['nacionalidad'] ?><br>
                                    Correo: <?php echo $dat['correo_expositor'] ?><br>
                                    Celular: <?php echo $dat['celular_expositor'] ?><br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </section>
        </div><?php
        break;
    case 2: 
        ?>
        <div class="Gestionar">
            <div class="table-responsive">        
                <table id="TablaPrograma" class="table table-striped table-bordered table-condensed" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th>Tema</th>
                            <th>Hora de Inicio</th>
                            <th>Hora Fin</th>
                            <th>Fecha</th>
                            <th>Expositor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $consulta= "SELECT tema, hora_inicio, hora_fin, fecha, nombres_expositor, apellidos_expositor 
                                    FROM programas p, expositores ex 
                                    WHERE p.cod_expositor=ex.cod_expositor AND cod_evento='$cod_evento' 
                                    ORDER BY fecha, hora_inicio";
                        $resultado = mysqli_query($conexion,$consulta);
                        $data = $resultado->fetch_all(MYSQLI_ASSOC);
                        if($data==null){?>
                            Aún no existe programa.
                        <?php
                        }else{
                            foreach($data as $dat) {?>
                            <tr>
                                <td><?php echo $dat['tema'] ?></td>
                                <td><?php echo $dat['hora_inicio'] ?></td>
                                <td><?php echo $dat['hora_fin'] ?></td>
                                <td><?php echo $dat['fecha'] ?></td>
                                <td><?php echo $dat['nombres_expositor']," ",$dat['apellidos_expositor'] ?></td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div><?php
        break;
}
$conexion->close();
?>