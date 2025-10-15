$(document).ready(function(){
    TablaComisiones = $("#TablaComisiones").DataTable({
        "columnDefs":[
            { "width": "5%", "targets": 0 },
            { "width": "15%", "targets": 1 },
            { "width": "60%", "targets": 2 },
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
        $("#FormComisiones").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Comisión");            
        $("#modalCRUD").modal("show");
        cod_comision=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_comision = parseInt(fila.find('td:eq(0)').text());
        nombre = fila.find('td:eq(1)').text();
        descripcion = fila.find('td:eq(2)').text();
        $("#nombre").val(nombre);
        $("#descripcion").val(descripcion);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Comisión");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_comision = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudComisiones.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_comision:cod_comision},
                    success: function(){
                        TablaComisiones.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
        
    $("#FormComisiones").submit(function(e){
        e.preventDefault();    //evita que se recargue
        nombre = $.trim($("#nombre").val());
        descripcion = $.trim($("#descripcion").val());
        if(nombre.length == "" || descripcion.length == ""){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudComisiones.php",
                type: "POST",
                dataType: "json",
                data: {nombre:nombre, descripcion:descripcion, cod_comision:cod_comision, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'error',
                            title: 'Ingreso datos incorrectos'
                        });
                    }else{
                        cod_comision = data[0].cod_comision;
                        nombre = data[0].nombre;
                        descripcion = data[0].descripcion;
                        if(opcion == 1){TablaComisiones.row.add([cod_comision,nombre,descripcion]).draw();}
                        else{TablaComisiones.row(fila).data([cod_comision,nombre,descripcion]).draw();}
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