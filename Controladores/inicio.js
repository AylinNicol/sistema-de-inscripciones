$(document).ready(function(){
    //botón CERTIFICADO    
    $(document).on("click", ".BtnCertificado", function(){
        Swal.fire({
            title: 'Ingrese su código de inscripción',
            html: `
                <input type="number" class="form-control" id="cod_inscripcion" min="1" oninput="validarNumeros(this)">
            `,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            preConfirm: () => {
                const cod_inscripcion = $("#cod_inscripcion").val();
                return $.ajax({
                    url: "./Modelos/verificarCodigo.php",
                    type: "POST",
                    dataType: "json",
                    data: {cod_inscripcion: cod_inscripcion},
                });
            },
        }).then((result) => {
            const cod_inscripcion = $("#cod_inscripcion").val();
            console.log(result);
            if (result.value == null) {
                Swal.fire({
                    type: 'error',
                    title: 'No se encuentra inscrito.'
                });
            } else {
                if(result.value == 1){
                    Swal.fire({
                        type: 'error',
                        title: 'No realizó el pago correspondiente'
                    });
                }else{
                    console.log(cod_inscripcion);
                    window.open("./Usuario/reportes/certificado.php?cod_inscripcion="+cod_inscripcion, "_blank");
                }
            }
        });
    });
});