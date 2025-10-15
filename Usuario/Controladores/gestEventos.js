$(document).ready(function(){
    $(".modal-dialog").css("max-width", "");
    $("#fecha_inicio, #fecha_fin").change(function() {
        fechaInicio = new Date($("#fecha_inicio").val());
        fechaFin = new Date($("#fecha_fin").val());

        if (fechaInicio > fechaFin) {
            Swal.fire({
                type: 'error',
                title: 'La fecha de final debe ser posterior a la fecha de inicio.'
            });
            $("#fecha_fin").val(""); // Limpia el campo de fecha de final
        }
    });
    TablaEventos = $("#TablaEventos").DataTable({
        "columnDefs":[
            { "width": "3%", "targets": 0 },
            { "width": "10%", "targets": 1 },
            { "width": "8%", "targets": 2 },
            { "width": "8%", "targets": 3 },
            { "width": "5%", "targets": 4 },
            { "width": "8%", "targets": 5 },
            { "width": "8%", "targets": 6 },
            { "width": "20%", "targets": 7 },
            {
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info BtnPoster'><i class='fas fa-image'></i> POSTER</button><button class='btn btn-info BtnCertificado'><i class='fas fa-certificate'></i> CERTIFICADO</button><button class='btn btn-info BtnMas'><i class='fas fa-info-circle'></i> MÁS...</button></div><br><div class='btn-group'><button class='btn btn-primary BtnEditar'><i class='fas fa-edit'></i> EDITAR</button><button class='btn btn-danger BtnBorrar'><i class='fas fa-eraser'></i> BORRAR</button></div></div>"
        }],
        "autoWidth": false,
        scrollX: false,
        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing":"Procesando...",
        }
    });
    $("#BtnNuevo").click(function(){
        $("#FormEventos").trigger("reset");
        $(".modal-dialog").css("max-width", "");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Evento");            
        $("#modalCRUD").modal("show");
        cod_evento=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón POSTER    
    $(document).on("click", ".BtnPoster", function(){
        fila = $(this).closest("tr");
        cod_evento = parseInt(fila.find('td:eq(0)').text());
        nombre_evento = fila.find('td:eq(1)').text();
        opcion = 4; //poster
        $.ajax({
            url: "../Modelos/crudEventos.php",
            type: "POST",
            dataType: "json",
            data: { cod_evento: cod_evento, opcion: opcion },
            success: function (data) {
                console.log(data);
                if (data == null) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error al cargar la imagen'
                    });
                } else {
                    poster = data[0].poster;
                    url = "../img/poster/"+poster;
                    $(".modal-dialog").css("max-width", "");
                    $(".modal-header").css("background-color", "#17a2b8");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("Evento: "+nombre_evento);
                    $(".modal-image").css({
                        'background-image': 'url(' + url + ')',
                        'background-size': 'contain',
                        'background-position': 'center',
                        'background-repeat': 'no-repeat',
                        'height': '500px',
                        'width': 'auto'
                    });
                    $("#modalPoster").modal("show");
                }
            }
        });
    });
    $("#FormPoster").submit(function(e){
        e.preventDefault();    //evita que se recargue
        posterFile = $("#poster")[0].files[0];
        opcion = 5; // subir poster
        formData = new FormData();
        formData.append("poster", posterFile);
        formData.append("cod_evento", cod_evento);
        formData.append("opcion", opcion);
        $.ajax({
            url: "../Modelos/crudEventos.php",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                if(data == null){
                    Swal.fire({
                        type: 'error',
                        title: 'Error al subir la imagen'
                    });
                }else{
                    poster = data[0].poster;
                    url = "../img/poster/"+poster;
                    $(".modal-image").css({
                        'background-image': 'url(' + url + ')'
                    });
                    Swal.fire({
                        type: 'success',
                        title: 'Imagen subida Exitosa!',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            }
        });
    });
    //botón CERTIFICADO    
    $(document).on("click", ".BtnCertificado", function(){
        fila = $(this).closest("tr");
        cod_evento = parseInt(fila.find('td:eq(0)').text());
        nombre_evento = fila.find('td:eq(1)').text();
        opcion = 6; //certificado
        $.ajax({
            url: "../Modelos/crudEventos.php",
            type: "POST",
            dataType: "json",
            data: { cod_evento: cod_evento, opcion: opcion },
            success: function (data) {
                console.log(data);
                if (data == null) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error al cargar la imagen'
                    });
                } else {
                    certificado = data[0].certificado;
                    url = "../img/certificado/"+certificado;
                    $(".modal-dialog").css("max-width", "");
                    $(".modal-header").css("background-color", "#17a2b8");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("Evento: "+nombre_evento);
                    $(".modal-image").css({
                        'background-image': 'url(' + url + ')',
                        'background-size': 'contain',
                        'background-position': 'center',
                        'background-repeat': 'no-repeat',
                        'height': '380px',
                        'width': 'auto'
                    });
                    $("#modalCertificado").modal("show");
                }
            }
        });
    });
    $("#FormCertificado").submit(function(e){
        e.preventDefault();    //evita que se recargue
        certificadoFile = $("#certificado")[0].files[0];
        opcion = 7; // subir certificado
        formData = new FormData();
        formData.append("certificado", certificadoFile);
        formData.append("cod_evento", cod_evento);
        formData.append("opcion", opcion);
        $.ajax({
            url: "../Modelos/crudEventos.php",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
                if(data == null){
                    Swal.fire({
                        type: 'error',
                        title: 'Error al subir la imagen'
                    });
                }else{
                    certificado = data[0].certificado;
                    url = "../img/certificado/"+certificado;
                    $(".modal-image").css({
                        'background-image': 'url(' + url + ')'
                    });
                    Swal.fire({
                        type: 'success',
                        title: 'Imagen subida Exitosa!',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                }
            }
        });
    });
    //botón MAS    
    $(document).on("click", ".BtnMas", function(){
        fila = $(this).closest("tr");
        cod_evento = parseInt(fila.find('td:eq(0)').text());
        nombre_evento = fila.find('td:eq(1)').text();
        $("#cod_evento").val(cod_evento);
        $("#nombre_evento").val(nombre_evento);
        localStorage.setItem("cod_evento", cod_evento);
        localStorage.setItem("nombre_evento", nombre_evento);
        opcion = 4; //mostrar
        $(".modal-dialog").css("max-width", "50%");
        $(".modal-header").css("background-color", "#17a2b8");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Evento: "+nombre_evento);            
        $("#modalMAS").modal("show");
        $.ajax({
            url: "../Modelos/crudMas.php",
            type: "POST",
            dataType: "json",
            data: { cod_evento: cod_evento, opcion: opcion },
            success: function (data) {
                if (data == null) {
                    Swal.fire({
                        type: 'error',
                        title: 'Ingreso datos incorrectos'
                    });
                } else {
                    TablaOrganizaciones.clear().draw();
                    for (i = 0; i < data.length; i++) {
                        row = data[i];
                        cod_detalle = row.cod_detalle;
                        organizador = row.organizador;
                        nombre = row.nombre;
                        TablaOrganizaciones.row.add([cod_detalle, organizador, nombre]);
                    }
                    TablaOrganizaciones.draw();
                }
            }
        });
    });
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_evento = parseInt(fila.find('td:eq(0)').text());
        nombre_evento = fila.find('td:eq(1)').text();
        tipo_evento = fila.find('td:eq(2)').text();
        carrera = fila.find('td:eq(3)').text();
        costo = parseInt(fila.find('td:eq(4)').text());
        fecha_inicio = fila.find('td:eq(5)').text();
        fecha_fin = fila.find('td:eq(6)').text();
        material = fila.find('td:eq(7)').text();
        $("#nombre_evento").val(nombre_evento);
        $("#tipo_evento").val(tipo_evento);
        $("#carrera").val(carrera);
        $("#costo").val(costo);
        $("#fecha_inicio").val(fecha_inicio);
        $("#fecha_fin").val(fecha_fin);
        $("#material").val(material);
        opcion = 2; //editar
        $(".modal-dialog").css("max-width", "");
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Evento");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_evento = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar
        Swal.fire({
            title: 'Está seguro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, elimínalo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                Swal.fire('Eliminado!', 'Su registro se eliminó.', 'success');
                $.ajax({
                    url: "../Modelos/crudEventos.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_evento:cod_evento},
                    success: function(){
                        TablaEventos.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormEventos").submit(function(e){
        e.preventDefault();    //evita que se recargue
        nombre_evento = $.trim($("#nombre_evento").val());
        tipo_evento = $.trim($("#tipo_evento").val());
        carrera = $.trim($("#carrera").val());  
        costo = $.trim($("#costo").val());  
        fecha_inicio = $.trim($("#fecha_inicio").val());
        fecha_fin = $.trim($("#fecha_fin").val());
        material = $.trim($("#material").val());
        if(nombre_evento.length == "" || tipo_evento.length == "" || carrera == "Seleccione una o ambas carreras" || costo.length == "" || fecha_inicio.length == "" || fecha_fin.length == "" || material.length == ""){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudEventos.php",
                type: "POST",
                dataType: "json",
                data: {nombre_evento:nombre_evento, tipo_evento:tipo_evento, carrera:carrera, costo:costo, fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, material:material, cod_evento:cod_evento, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'error',
                            title: 'Ingreso datos incorrectos'
                        });
                    }else{
                        cod_evento = data[0].cod_evento;
                        nombre_evento = data[0].nombre_evento;
                        tipo_evento = data[0].tipo_evento;
                        carrera = data[0].carrera;
                        costo = data[0].costo;
                        fecha_inicio = data[0].fecha_inicio;
                        fecha_fin = data[0].fecha_fin;
                        material = data[0].material;
                        if(opcion == 1){TablaEventos.row.add([cod_evento,nombre_evento,tipo_evento,carrera,costo,fecha_inicio,fecha_fin,material]).draw();}
                        else{TablaEventos.row(fila).data([cod_evento,nombre_evento,tipo_evento,carrera,costo,fecha_inicio,fecha_fin,material]).draw();}
                        Swal.fire({
                            type: 'success',
                            title: 'Operación Exitosa!',
                            showConfirmButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
        $("#modalCRUD").modal("hide");
    });
});