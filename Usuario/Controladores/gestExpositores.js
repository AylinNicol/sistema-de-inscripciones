$(document).ready(function(){
    TablaExpositores = $("#TablaExpositores").DataTable({
        "columnDefs":[
            { "width": "8%", "targets": 0 },
            { "width": "8%", "targets": 1 },
            { "width": "12%", "targets": 2 },
            { "width": "12%", "targets": 3 },
            { "width": "8%", "targets": 4 },
            { "width": "17%", "targets": 5 },
            { "width": "12%", "targets": 6 },
            {
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info BtnFoto'><i class='fas fa-image'></i> FOTO</button><button class='btn btn-primary BtnEditar'><i class='fas fa-edit'></i> EDITAR</button><button class='btn btn-danger BtnBorrar'><i class='fas fa-eraser'></i> BORRAR</button></div></div>"
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
        $("#FormExpositores").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Expositor");            
        $("#modalCRUD").modal("show");
        cod_expositor=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón FOTO    
    $(document).on("click", ".BtnFoto", function(){
        fila = $(this).closest("tr");
        cod_expositor = parseInt(fila.find('td:eq(0)').text());
        nombres_expositor = fila.find('td:eq(2)').text();
        apellidos_expositor = fila.find('td:eq(3)').text();
        opcion = 4; //foto
        $.ajax({
            url: "../Modelos/crudExpositores.php",
            type: "POST",
            dataType: "json",
            data: { cod_expositor: cod_expositor, opcion: opcion },
            success: function (data) {
                console.log(data);
                if (data == null) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error al cargar la imagen'
                    });
                } else {
                    foto_expositor = data[0].foto_expositor;
                    url = "../img/expositores/"+foto_expositor;
                    $(".modal-header").css("background-color", "#17a2b8");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("Expositor: "+nombres_expositor+" "+apellidos_expositor);
                    $(".modal-image").css({
                        'background-image': 'url(' + url + ')',
                        'background-size': 'contain',
                        'background-position': 'center',
                        'background-repeat': 'no-repeat',
                        'height': '400px',
                        'width': 'auto'
                    });
                    $("#modalFoto").modal("show");
                }
            }
        });
    });
    $("#FormFoto").submit(function(e){
        e.preventDefault();    //evita que se recargue
        fotoFile = $("#foto_expositor")[0].files[0];
        opcion = 5; // subir foto
        formData = new FormData();
        formData.append("foto_expositor", fotoFile);
        formData.append("cod_expositor", cod_expositor);
        formData.append("opcion", opcion);
        $.ajax({
            url: "../Modelos/crudExpositores.php",
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
                    foto_expositor = data[0].foto_expositor;
                    url = "../img/expositores/"+foto_expositor;
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
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_expositor = parseInt(fila.find('td:eq(0)').text());
        ci_expositor = fila.find('td:eq(1)').text();
        nombres_expositor = fila.find('td:eq(2)').text();
        apellidos_expositor = fila.find('td:eq(3)').text();
        celular_expositor = parseInt(fila.find('td:eq(4)').text());
        correo_expositor = fila.find('td:eq(5)').text();
        nacionalidad = fila.find('td:eq(6)').text();
        $("#ci_expositor").val(ci_expositor);
        $("#nombres_expositor").val(nombres_expositor);
        $("#apellidos_expositor").val(apellidos_expositor);
        $("#celular_expositor").val(celular_expositor);
        $("#correo_expositor").val(correo_expositor);
        $("#nacionalidad").val(nacionalidad);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Expositor");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_expositor = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudExpositores.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_expositor:cod_expositor},
                    success: function(){
                        TablaExpositores.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormExpositores").submit(function(e){
        e.preventDefault();    //evita que se recargue
        ci_expositor = $.trim($("#ci_expositor").val());
        nombres_expositor = $.trim($("#nombres_expositor").val());
        apellidos_expositor = $.trim($("#apellidos_expositor").val());
        celular_expositor = $.trim($("#celular_expositor").val());  
        correo_expositor = $.trim($("#correo_expositor").val());  
        nacionalidad = $.trim($("#nacionalidad").val());
        if(ci_expositor.lenght == "" || nombres_expositor.length == "" || apellidos_expositor.length == "" || celular_expositor.length == "" || correo_expositor.length == "" || nacionalidad == "Seleccione una nacionalidad"){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudExpositores.php",
                type: "POST",
                dataType: "json",
                data: {ci_expositor:ci_expositor, nombres_expositor:nombres_expositor, apellidos_expositor:apellidos_expositor, celular_expositor:celular_expositor, correo_expositor:correo_expositor, nacionalidad:nacionalidad, cod_expositor:cod_expositor, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'warning',
                            title: 'Ya existe un expositor registrado con el mismo C.I.'
                        });
                    }else{
                        cod_expositor = data[0].cod_expositor;
                        ci_expositor = data[0].ci_expositor;
                        nombres_expositor = data[0].nombres_expositor;
                        apellidos_expositor = data[0].apellidos_expositor;
                        celular_expositor = data[0].celular_expositor;
                        correo_expositor = data[0].correo_expositor;
                        nacionalidad = data[0].nacionalidad;
                        if(opcion == 1){TablaExpositores.row.add([cod_expositor,ci_expositor,nombres_expositor,apellidos_expositor,celular_expositor,correo_expositor,nacionalidad]).draw();}
                        else{TablaExpositores.row(fila).data([cod_expositor,ci_expositor,nombres_expositor,apellidos_expositor,celular_expositor,correo_expositor,nacionalidad]).draw();}
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