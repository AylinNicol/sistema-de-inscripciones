$(document).ready(function(){
    cod_evento = localStorage.getItem("cod_evento");
    nombre_evento = localStorage.getItem("nombre_evento");
    TablaOrganizaciones = $("#TablaOrganizaciones").DataTable({
        "columnDefs":[
            { "width": "5%", "targets": 0 },
            { "width": "7%", "targets": 1 },
            { "width": "7%", "targets": 2 },
            {
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary BtnEditarMas'><i class='fas fa-edit'></i> EDITAR</button><button class='btn btn-danger BtnBorrarMas'><i class='fas fa-eraser'></i> BORRAR</button></div></div>"
        }],
        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "",
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
    $("#BtnNuevoMas").click(function(){
        $("#FormOrganizaciones").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo");            
        $("#modalCRUDMas").modal("show");
        cod_detalle=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón EDITAR    
    $(document).on("click", ".BtnEditarMas", function(){
        fila = $(this).closest("tr");
        cod_detalle = parseInt(fila.find('td:eq(0)').text());
        organizador = fila.find('td:eq(1)').text();
        nombre = fila.find('td:eq(2)').text();
        $("#organizador").val(organizador);
        $("#nombre").val(nombre);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar");            
        $("#modalCRUDMas").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrarMas", function(){
        fila = $(this);
        cod_detalle = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudMas.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_detalle:cod_detalle},
                    success: function(){
                        TablaOrganizaciones.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormOrganizaciones").submit(function(e){
        e.preventDefault();    //evita que se recargue
        organizador = $.trim($("#organizador").val());
        nombre = $.trim($("#nombre").val());
        if(organizador == "Seleccione un organizador" || nombre == "Seleccione una comision" ){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudMas.php",
                type: "POST",
                dataType: "json",
                data: {cod_evento:cod_evento, organizador:organizador, nombre:nombre, cod_detalle:cod_detalle, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'error',
                            title: 'Ingreso datos incorrectos'
                        });
                    }else{
                        cod_detalle = data[0].cod_detalle;
                        organizador = data[0].organizador;
                        nombre = data[0].nombre;
                        if(opcion == 1){TablaOrganizaciones.row.add([cod_detalle,organizador,nombre]).draw();}
                        else{TablaOrganizaciones.row(fila).data([cod_detalle,organizador,nombre]).draw();}
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
        $("#modalCRUDMas").modal("hide");
        $(".modal-dialog").css("max-width", "50%");
        $(".modal-header").css("background-color", "#17a2b8");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Evento: "+nombre_evento);
        $("#modalMAS").modal("show");
    });
    $('#modalCRUDMas').on('hidden.bs.modal', function () {
        $(".modal-dialog").css("max-width", "50%");
        $(".modal-header").css("background-color", "#17a2b8");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Evento: "+nombre_evento);
        $("#modalMAS").modal("show");
    });
});