$(document).ready(function(){
    TablaInscripciones = $("#TablaInscripciones").DataTable({
        "columnDefs":[
            { "width": "5%", "targets": 0 },
            { "width": "8%", "targets": 1 },
            { "width": "25%", "targets": 2 },
            { "width": "8%", "targets": 3 },
            { "width": "7%", "targets": 4 },
            { "width": "10%", "targets": 5 },
            {
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info BtnCertificado'><i class='fas fa-certificate'></i> CERTIFICADO</button><button class='btn btn-info BtnRecibo'><i class='fas fa-file'></i> RECIBO</button><button class='btn btn-primary BtnEditar'><i class='fas fa-edit'></i> EDITAR</button><button class='btn btn-danger BtnBorrar'><i class='fas fa-eraser'></i> BORRAR</button></div></div>"
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
        $("#FormInscripciones").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Inscripción");            
        $("#modalCRUD").modal("show");
        cod_inscripcion=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón CERTIFICADO    
    $(document).on("click", ".BtnCertificado", function(){
        fila = $(this).closest("tr");
        cod_inscripcion = parseInt(fila.find('td:eq(0)').text());
        pago = fila.find('td:eq(4)').text();
        if (pago === "SI") {
            window.open("../Usuario/reportes/certificado.php?cod_inscripcion="+cod_inscripcion, "_blank");
        } else if (pago === "NO") {
            Swal.fire({
                type: 'error',
                title: 'No realizó el pago correspondiente'
            });
        }
    });
    //botón RECIBO    
    $(document).on("click", ".BtnRecibo", function(){
        fila = $(this).closest("tr");
        cod_inscripcion = parseInt(fila.find('td:eq(0)').text());
        pago = fila.find('td:eq(4)').text();
        if (pago === "SI") {
            window.open("../Usuario/reportes/recibo.php?cod_inscripcion="+cod_inscripcion, "_blank");
        } else if (pago === "NO") {
            Swal.fire({
                type: 'error',
                title: 'No realizó el pago correspondiente'
            });
        }
    });
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_inscripcion = parseInt(fila.find('td:eq(0)').text());
        ci = parseInt(fila.find('td:eq(1)').text());
        nombre_evento = fila.find('td:eq(2)').text();
        pago = fila.find('td:eq(4)').text();
        promocion = parseInt(fila.find('td:eq(5)').text());
        $("#ci").val(ci);
        $("#nombre_evento").val(nombre_evento);
        if (pago === "SI") {
            $("#pago_SI").prop("checked", true);
        } else if (pago === "NO") {
            $("#pago_NO").prop("checked", true);
        }
        $("#promocion").val(promocion);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Inscripción");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_inscripcion = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudInscripciones.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_inscripcion:cod_inscripcion},
                    success: function(){
                        TablaInscripciones.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormInscripciones").submit(function(e){
        e.preventDefault();    //evita que se recargue
        ci = $.trim($("#ci").val());
        nombre_evento = $.trim($("#nombre_evento").val());
        if ($("#pago_SI").is(":checked")) {
            pago = $.trim($("#pago_SI").val());
        } else if ($("#pago_NO").is(":checked")) {
            pago = $.trim($("#pago_NO").val());
        }else{
            pago = "";
        }
        promocion = $.trim($("#promocion").val());
        if(ci == "Seleccione un C.I." || nombre_evento == "Seleccione un evento" || pago.length == "" || promocion.length == ""){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudInscripciones.php",
                type: "POST",
                dataType: "json",
                data: {ci:ci,nombre_evento:nombre_evento, pago:pago, promocion:promocion, cod_inscripcion:cod_inscripcion, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'error',
                            title: 'Ingreso datos incorrectos'
                        });
                    }else{
                        cod_inscripcion = data[0].cod_inscripcion;
                        ci = data[0].ci;
                        nombre_evento = data[0].nombre_evento;
                        fecha_inscripcion = data[0].fecha_inscripcion;
                        pago = data[0].pago;
                        promocion = data[0].promocion;
                        prom=promocion*100;
                        if(opcion == 1){TablaInscripciones.row.add([cod_inscripcion,ci,nombre_evento,fecha_inscripcion,pago,prom]).draw();}
                        else{TablaInscripciones.row(fila).data([cod_inscripcion,ci,nombre_evento,fecha_inscripcion,pago,prom]).draw();}
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