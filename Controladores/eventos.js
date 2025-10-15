$(document).ready(function(){
    $('.imagen-clickeable').click(function() {
        $(this).toggleClass('imagen-ampliada');
    });
    TablaEventos = $("#TablaEventos").DataTable({
        "columnDefs":[{
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn BtnExpositores'><i class='fas fa-users'></i> EXPOSITORES</button></div><br><br><div class='btn-group'><button class='btn BtnPrograma'><i class='fas fa-file-alt'></i> PROGRAMA</button></div></div>"
        }],
        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ eventos",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando eventos del _START_ al _END_ de un total de _TOTAL_ eventos",
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
    //botón EXPOSITORES    
    $(document).on("click", ".BtnExpositores", function(){
        fila = $(this).closest("tr");
        altDeLaImagen = fila.find('img.imagen-clickeable').attr('alt');
        cod_evento = altDeLaImagen;
        opcion = 1;
        $.ajax({
            url: "./Modelos/datosEventos.php",
            type: "POST",
            data: { cod_evento: cod_evento, opcion:opcion},
            success: function(result) {
                contenidoModal = result;
                $("#modalExpositores .modal-body").html(contenidoModal);
                $(".modal-header").css("background-color", "#17a2b8");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Expositores");            
                $("#modalExpositores").modal("show");
            },
            error: function() {
                // Manejo de errores
                alert("Error en la consulta");
            }
        });
    });
    //botón PROGRAMAS    
    $(document).on("click", ".BtnPrograma", function(){
        fila = $(this).closest("tr");
        altDeLaImagen = fila.find('img.imagen-clickeable').attr('alt');
        cod_evento = altDeLaImagen;
        opcion = 2;
        $.ajax({
            url: "./Modelos/datosEventos.php",
            type: "POST",
            data: { cod_evento: cod_evento, opcion:opcion},
            success: function(result) {
                contenidoModal = result;
                $("#modalPrograma .modal-body").html(contenidoModal);
                $(".modal-header").css("background-color", "#17a2b8");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Programa");            
                $("#modalPrograma").modal("show");
            },
            error: function() {
                // Manejo de errores
                alert("Error en la consulta");
            }
        });
    });
});