    <!--PARTE SUPERIOR-->
    <?php require "../Vistas/ParteSuperiorReportes.php";
    $consulta ="SELECT nombre_evento, COUNT(cod_inscripcion) AS cantidad
                FROM eventos e, inscripciones i
                WHERE e.cod_evento = i.cod_evento
                GROUP BY e.cod_evento";
    $resultado = mysqli_query($conexion,$consulta);
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>
    <!--TITULO-->
    <header>
        <h1>REPORTE GRÁFICO DE EVENTOS</h1>
    </header>
    <!--................................-->    
    <h4 class="text-right">Usuario: <span class="badge badge-info"><?php echo $nombres_usuario, " ", $apellidos_usuario;?></span></h4>
    <div class="Grafico">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
            foreach($data as $dat) {
                echo "['",$dat['nombre_evento'],"', ",$dat['cantidad'], "], ";
            }
            ?>
            ]);
            var options = {
            title: 'Eventos Académicos'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        </script>
        <div id="piechart" style="width: auto; height: 600px; margin-left: 80px;"></div>
    </div>
    <!--PARTE INFERIOR-->
    <?php require "../Vistas/ParteInferiorReportes.php"?>    
</body>
</html>
