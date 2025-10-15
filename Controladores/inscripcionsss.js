$(document).ready(function() {
    //botón BUSCAR
    $("#BtnBuscar").on("click", function() {
        ci = $("#ci").val();
        opcion = 2; //buscar
        if(ci.length == ""){ //.length es la cantidad de caracteres
            Swal.fire({
                type: 'warning',
                title: 'Ingrese su carnet de identidad',
            });
            return false;
        }else{
            $.ajax({
                url: "./Modelos/inscripcionesC.php",
                type: "POST",
                dataType: "json",
                data: {opcion:opcion, ci:ci},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'warning',
                            title: 'No se encontró sus datos',
                        });
                    }else{
                        ci = data.ci;
                        nombres_participante = data.nombres_participante;
                        apellidos_participante = data.apellidos_participante;
                        celular = data.celular;
                        correo = data.correo;
                        institucion = data.institucion;
                        $("#ci").val(ci);
                        $("#ci").prop("disabled", true);
                        $("#nombres_participante").val(nombres_participante);
                        $("#nombres_participante").prop("disabled", true);
                        $("#apellidos_participante").val(apellidos_participante);
                        $("#apellidos_participante").prop("disabled", true);
                        $("#celular").val(celular);
                        $("#celular").prop("disabled", true);
                        $("#correo").val(correo);
                        $("#correo").prop("disabled", true);
                        $("#institucion").append($("<option>").text(institucion).val(institucion));
                        $("#institucion").val(institucion);
                        $("#institucion").prop("disabled", true);
                        Swal.fire({
                            type: 'success',
                            title: 'Se encontraron sus datos!',
                            showConfirmButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
    });
    //botón INSCRIBIRSE
    $("#FormInscripciones").submit(function(e){
        e.preventDefault();    //evita que se recargue
        ci = $.trim($("#ci").val());
        nombres_participante = $.trim($("#nombres_participante").val());
        apellidos_participante = $.trim($("#apellidos_participante").val());
        celular = $.trim($("#celular").val());
        correo = $.trim($("#correo").val());
        nombre_evento = $.trim($("#nombre_evento").val());
        institucion = $.trim($("#institucion").val());
        opcion = 1; //registrar
        if(celular.length == ""){ //.length es la cantidad de caracteres
            celular = "0";
        }
        if(correo.length == ""){ //.length es la cantidad de caracteres
            correo = "-";
        }
        if(ci.length == "" || nombres_participante.length == "" || apellidos_participante.length == "" || nombre_evento == "Seleccione un evento" || institucion == "Seleccione una carrera o institución"){ //.length es la cantidad de caracteres
            Swal.fire({
                type: 'warning',
                title: 'Ingrese los datos necesarios',
            });
            return false;
        }else{
            $.ajax({
                url: "./Modelos/inscripcionesC.php",
                type: "POST",
                dataType: "json",
                data: {ci:ci,nombres_participante:nombres_participante,apellidos_participante:apellidos_participante, celular:celular, correo:correo, nombre_evento:nombre_evento, institucion:institucion,opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'success',
                            title: 'Usted ya se encuentra inscrito!'
                        });
                    }else{
                        cod_inscripcion = data.cod_inscripcion;
                        ci = data.ci;
                        nombres_participante = data.nombres_participante;
                        apellidos_participante = data.apellidos_participante;
                        celular = data.celular;
                        correo = data.correo;
                        institucion = data.institucion;
                        $("#ci").val(ci);
                        $("#ci").prop("disabled", true);
                        $("#nombres_participante").val(nombres_participante);
                        $("#nombres_participante").prop("disabled", true);
                        $("#apellidos_participante").val(apellidos_participante);
                        $("#apellidos_participante").prop("disabled", true);
                        $("#celular").val(celular);
                        $("#celular").prop("disabled", true);
                        $("#correo").val(correo);
                        $("#correo").prop("disabled", true);
                        $("#institucion").append($("<option>").text(institucion).val(institucion));
                        $("#institucion").val(institucion);
                        $("#institucion").prop("disabled", true);
                        Swal.fire({
                            type: 'success',
                            title: 'Inscripción Exitosa!',
                            html:
                            'Guarde el código de inscripción para obtener su certificado.<br>Su <b>código de inscripción</b> es: '+cod_inscripcion,
                            showConfirmButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        }
    });
});
