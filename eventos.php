<?php
include "./Modelos/conexion.php";
$consulta= "SELECT * 
            FROM eventos 
            WHERE fecha_fin >= CURDATE() 
            ORDER BY fecha_inicio";
$resultado = mysqli_query($conexion,$consulta);
$data = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="./lib/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="./lib/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="./css/bases.css">
    <link rel="stylesheet" href="./css/event.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="./img/LOGO.png">
</head>
 <body>
    <!--FONDO-->
    <div class="hero">
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
    </div>
    <!--MENU-->
    <?php require "Vistas/Menu.php"?>
    <div class="general mt-3 mb-5 ">
        <h1>EVENTOS</h1>
        <div class="Gestionar">
            <div class="table-responsive">
                <table id="TablaEventos">
                    <thead class="text-center">
                        <tr>
                            <th><br></th>
                            <th><br>General</th>
                            <th><br>Información</th>
                            <th><br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($data as $dat) {?>
                        <tr>
                            <div class="fila mb-1 mt-0">
                                <td class="item col-md-3">
                                    <img src="./img/poster/<?php echo $dat['poster'] ?>" alt="<?php echo $dat['cod_evento'] ?>" width=250px class="imagen-clickeable"/>
                                    <br><br>
                                </td>
                                <td class="item col-md-3">
                                <br><?php echo $dat['nombre_evento'] ?>
                                <br><br>Tipo: <?php echo $dat['tipo_evento'] ?>
                                <br><?php echo $dat['material'] ?><br>
                                </td>
                                <td class="item col-md-4">
                                <br>Fecha de incio: <i class='fas fa-hand-point-right'></i> <?php echo $dat['fecha_inicio'] ?>
                                <br>Fecha de finalización: <i class='fas fa-hand-point-right'></i> <?php echo $dat['fecha_fin'] ?>
                                <br>Costo de inscripción: <i class='fas fa-hand-point-right'></i> <?php echo $dat['costo'] ?> Bs.
                                <br>Organizada por: <i class='fas fa-hand-point-right'></i> <?php echo $dat['carrera'] ?><br>
                                </td>
                                <td class="item col-md-2"></td>
                            </div>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--Modal para EXPOSITORES-->
    <div class="modal fade" id="modalExpositores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <!--Modal para PROGRAMA-->
    <div class="modal fade" id="modalPrograma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="./lib/jquery/jquery-3.3.1.min.js"></script>
    <script src="./lib/popper/popper.min.js"></script>
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="./lib/datatables/datatables.min.js"></script>
    <!-- JS personalizado -->
    <script type="text/javascript" src="./Controladores/eventos.js"></script>
</body>
</html>

