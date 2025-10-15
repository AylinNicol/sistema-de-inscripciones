<?php
include "./Modelos/conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="./css/bases.css">
    <link rel="stylesheet" href="./css/administrativo.css">
    <title>Eventos Académicos</title>
    <link rel="icon" href="./img/LOGO.png">
</head>
<body>
    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!--MENU-->
    <?php require "Vistas/Menu.php"?>
    <!--RESTO-->
    <div class="general mt-3 mb-0 mx-auto">
        <h1>ADMINISTRATIVOS</h1>
        <section class="contenido">
            <div class="Mostrador" id="Mostrador">
                <?php
                $consulta= "SELECT * FROM usuarios u, administrativos a WHERE u.cod_usuario=a.cod_usuario";
                $resultado = mysqli_query($conexion,$consulta);
                $data = $resultado->fetch_all(MYSQLI_ASSOC);
                $cant = 1;
                $total = mysqli_num_rows($resultado);
                foreach($data as $dat) {
                    if(($cant-1)%3 == 0){?>
                        <div class="fila">
                            <div class="item ">
                                <div class="foto">
                                    <img src="./img/usuarios/<?php echo $dat['foto_usuario'] ?>" alt="" height="200px" width="200px">
                                    <p class="descripcion"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?><br><?php echo $dat['cargo'] ?>
                                        <br><?php echo $dat['correo_usuario'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        $cant=$cant+1;
                    }else if($cant%3 == 0 || $cant>$total){?>
                            <div class="item ">
                                <div class="foto">
                                    <img src="./img/usuarios/<?php echo $dat['foto_usuario'] ?>" alt="" height="200px" width="200px">
                                    <p class="descripcion"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?><br><?php echo $dat['cargo'] ?>
                                        <br><?php echo $dat['correo_usuario'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cant=$cant+1;
                    }else{?>
                        <div class="item ">
                            <div class="foto">
                                <img src="./img/usuarios/<?php echo $dat['foto_usuario'] ?>" alt="" height="200px" width="200px">
                                <p class="descripcion"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?><br><?php echo $dat['cargo'] ?>
                                    <br><?php echo $dat['correo_usuario'] ?>
                                </p>
                            </div>
                        </div>
                    <?php
                    $cant=$cant+1;
                    }
                }
                ?>
            </div>
        </section>
        <h1>ORGANIZADORES</h1>
        <section class="contenido">
            <div class="Mostrador" id="Mostrador">
                <?php
                $consulta= "SELECT * FROM usuarios u, organizadores o WHERE u.cod_usuario=o.cod_usuario";
                $resultado = mysqli_query($conexion,$consulta);
                $data = $resultado->fetch_all(MYSQLI_ASSOC);
                $cant = 1;
                $total = mysqli_num_rows($resultado);
                foreach($data as $dat) {
                    if(($cant-1)%3 == 0){?>
                        <div class="fila">
                            <div class="item ">
                                <div class="foto">
                                    <img src="./img/usuarios/<?php echo $dat['foto_usuario'] ?>" alt="" height="200px" width="200px">
                                    <p class="descripcion"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?><br><?php echo $dat['celular'] ?>
                                        <br><?php echo $dat['correo_usuario'] ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        $cant=$cant+1;
                    }else if($cant%3 == 0 || $cant>$total){?>
                            <div class="item ">
                                <div class="foto">
                                    <img src="./img/usuarios/<?php echo $dat['foto_usuario'] ?>" alt="" height="200px" width="200px">
                                    <p class="descripcion"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?><br><?php echo $dat['celular'] ?>
                                        <br><?php echo $dat['correo_usuario'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cant=$cant+1;
                    }else{?>
                        <div class="item ">
                            <div class="foto">
                                <img src="./img/usuarios/<?php echo $dat['foto_usuario'] ?>" alt="" height="200px" width="200px">
                                <p class="descripcion"><?php echo $dat['nombres_usuario']," ",$dat['apellidos_usuario'] ?><br><?php echo $dat['celular'] ?>
                                    <br><?php echo $dat['correo_usuario'] ?>
                                </p>
                            </div>
                        </div>
                    <?php
                    $cant=$cant+1;
                    }
                }
                ?>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>