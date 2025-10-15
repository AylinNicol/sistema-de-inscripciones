$(document).ready(function(){
    TablaParticipantes = $("#TablaParticipantes").DataTable({
        "columnDefs":[
            { "width": "8%", "targets": 0 },
            { "width": "8%", "targets": 1 },
            { "width": "12%", "targets": 2 },
            { "width": "12%", "targets": 3 },
            { "width": "8%", "targets": 4 },
            { "width": "15%", "targets": 5 },
            { "width": "18%", "targets": 6 },
            {
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary BtnEditar'><i class='fas fa-edit'></i> EDITAR</button><button class='btn btn-danger BtnBorrar'><i class='fas fa-eraser'></i> BORRAR</button></div></div>"
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
        $("#FormParticipantes").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Participante");            
        $("#modalCRUD").modal("show");
        cod_participante=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_participante = parseInt(fila.find('td:eq(0)').text());
        ci = parseInt(fila.find('td:eq(1)').text());
        nombres_participante = fila.find('td:eq(2)').text();
        apellidos_participante = fila.find('td:eq(3)').text();
        celular = parseInt(fila.find('td:eq(4)').text());
        correo = fila.find('td:eq(5)').text();
        institucion = fila.find('td:eq(6)').text();
        $("#ci").val(ci);
        $("#nombres_participante").val(nombres_participante);
        $("#apellidos_participante").val(apellidos_participante);
        $("#celular").val(celular);
        $("#correo").val(correo);
        $("#institucion").val(institucion);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Participante");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_participante = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudParticipantes.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_participante:cod_participante},
                    success: function(){
                        TablaParticipantes.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormParticipantes").submit(function(e){
        e.preventDefault();    //evita que se recargue
        ci = $.trim($("#ci").val());
        nombres_participante = $.trim($("#nombres_participante").val());
        apellidos_participante = $.trim($("#apellidos_participante").val());
        celular = $.trim($("#celular").val());  
        correo = $.trim($("#correo").val());
        institucion = $.trim($("#institucion").val());
        if(celular.length == ""){ //.length es la cantidad de caracteres
            celular = "0";
        }
        if(correo.length == ""){ //.length es la cantidad de caracteres
            correo = "-";
        }
        if(ci.length == "" || nombres_participante.length == "" || apellidos_participante.length == "" || institucion == "Seleccione una carrera o institución"){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudParticipantes.php",
                type: "POST",
                dataType: "json",
                data: {ci:ci,nombres_participante:nombres_participante, apellidos_participante:apellidos_participante, celular:celular, correo:correo, institucion:institucion, cod_participante:cod_participante, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'error',
                            title: 'Ingreso datos incorrectos'
                        });
                    }else{
                        cod_participante = data[0].cod_participante;
                        ci = data[0].ci;
                        nombres_participante = data[0].nombres_participante;
                        apellidos_participante = data[0].apellidos_participante;
                        celular = data[0].celular;
                        correo = data[0].correo;
                        institucion = data[0].institucion;
                        if(opcion == 1){TablaParticipantes.row.add([cod_participante,ci,nombres_participante,apellidos_participante,celular,correo,institucion]).draw();}
                        else{TablaParticipantes.row(fila).data([cod_participante,ci,nombres_participante,apellidos_participante,celular,correo,institucion]).draw();}
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