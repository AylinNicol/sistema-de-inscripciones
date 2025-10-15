$(document).ready(function(){
    $("#hora_inicio, #hora_fin").change(function() {
        horaInicio = $("#hora_inicio").val();
        horaFin = $("#hora_fin").val();

        if (horaInicio >= horaFin) {
            Swal.fire({
                type: 'error',
                title: 'La hora de final debe ser posterior a la hora de inicio.'
            });
            $("#hora_fin").val(""); // Limpia el campo de hora de final
        }
    });
    TablaProgramas = $("#TablaProgramas").DataTable({
        "columnDefs":[
            { "width": "5%", "targets": 0 },
            { "width": "17%", "targets": 1 },
            { "width": "20%", "targets": 2 },
            { "width": "10%", "targets": 3 },
            { "width": "10%", "targets": 4 },
            { "width": "8%", "targets": 5 },
            { "width": "12%", "targets": 6 },
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
        $("#FormProgramas").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Programa");            
        $("#modalCRUD").modal("show");
        cod_programa=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_programa = parseInt(fila.find('td:eq(0)').text());
        nombre_evento = fila.find('td:eq(1)').text();
        tema = fila.find('td:eq(2)').text();
        hora_inicio = fila.find('td:eq(3)').text();
        hora_fin = fila.find('td:eq(4)').text();
        fecha = fila.find('td:eq(5)').text();
        expositor = fila.find('td:eq(6)').text();
        $("#nombre_evento").val(nombre_evento);
        $("#tema").val(tema);
        $("#hora_inicio").val(hora_inicio);
        $("#hora_fin").val(hora_fin);
        $("#fecha").val(fecha);
        $("#expositor").val(expositor);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Programa");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_programa = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudProgramas.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_programa:cod_programa},
                    success: function(){
                        TablaProgramas.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormProgramas").submit(function(e){
        e.preventDefault();    //evita que se recargue
        nombre_evento = $.trim($("#nombre_evento").val());
        tema = $.trim($("#tema").val());
        hora_inicio = $.trim($("#hora_inicio").val());
        hora_fin = $.trim($("#hora_fin").val());  
        fecha = $.trim($("#fecha").val());
        expositor = $.trim($("#expositor").val());
        if(nombre_evento == "Seleccione un evento" || tema.length == "" || hora_inicio.length == "" || hora_fin.length == "" || fecha.length == "" || expositor == "Seleccione un expositor"){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudProgramas.php",
                type: "POST",
                dataType: "json",
                data: {nombre_evento:nombre_evento,tema:tema, hora_inicio:hora_inicio, hora_fin:hora_fin, fecha:fecha, expositor:expositor, cod_programa:cod_programa, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'error',
                            title: 'Hubo un error en la operación.',
                            text: '(Distinto de 0)',
                            html: `
                                <div style="color: black; font-size: 20px;">Verifique que la fecha del programa esté dentro de las fechas del evento o que no exista otro programa en el horario que ingreso.</div>
                            `,
                        });
                    }else{
                        cod_programa = data[0].cod_programa;
                        nombre_evento = data[0].nombre_evento;
                        tema = data[0].tema;
                        hora_inicio = data[0].hora_inicio;
                        hora_fin = data[0].hora_fin;
                        fecha = data[0].fecha;
                        expositor = data[0].expositor;
                        if(opcion == 1){TablaProgramas.row.add([cod_programa,nombre_evento,tema,hora_inicio,hora_fin,fecha,expositor]).draw();}
                        else{TablaProgramas.row(fila).data([cod_programa,nombre_evento,tema,hora_inicio,hora_fin,fecha,expositor]).draw();}
                        Swal.fire({
                            type: 'success',
                            title: 'Operación Exitosa!',
                            showConfirmButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                        $("#modalCRUD").modal("hide");
                    }
                }
            });
        }
    });
});