$(document).ready(function(){
    TablaEventos = $("#TablaEventos").DataTable({
        "searching": false,
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
    $(document).on("click", "#BtnGenerarEventos", function(){
        window.open("../Usuario/reportes/rEventos.php", "_blank");
    });
    $(document).on("click", "#BtnGenerarCalculoEventos", function(){
        window.open("../Usuario/reportes/cEventos.php", "_blank");
    });
    $(document).on("click", "#BtnGenerarParticipantes", function(){
        window.open("../Usuario/reportes/rParticipantes.php", "_blank");
    });
});