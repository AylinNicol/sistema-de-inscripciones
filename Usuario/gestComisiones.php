    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorGestionar.php";
        $consulta= "SELECT * 
                    FROM comisiones";
        $resultado = mysqli_query($conexion,$consulta);
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>    
    <!--TITULO-->
    <header>
        <h1>GESTIONAR COMISIONES</h1>
    </header>
    <!--................................-->
    <?php require "../Vistas/SupTabla.php";?>
                    <table id="TablaComisiones" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['cod_comision'] ?></td>
                                <td><?php echo $dat['nombre'] ?></td>
                                <td><?php echo $dat['descripcion'] ?></td>
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
                <form id="FormComisiones">    
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" minlength="3" maxlength="30" oninput="validarLetras(this)">
                        </div>
                        <div class="form-group">
                        <label for="pais" class="col-form-label">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" minlength="15" maxlength="300" oninput="validarLetrasyNumeros(this)">
                        </div>
                    </div>
    <?php require "../Vistas/InfModal.php";?>
    
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorGestionar.php"?>

    <script type="text/javascript" src="./Controladores/gestComisiones.js"></script>  
    
</body>
</html>
