$(document).ready(function(){
    TablaOrganizadores = $("#TablaOrganizadores").DataTable({
        "columnDefs":[
            { "width": "5%", "targets": 0 },
            { "width": "5%", "targets": 1 },
            { "width": "8%", "targets": 2 },
            { "width": "8%", "targets": 3 },
            { "width": "5%", "targets": 4 },
            { "width": "5%", "targets": 5 },
            { "width": "8%", "targets": 6 },
            { "width": "8%", "targets": 7 },
            { "width": "5%", "targets": 8 },
            {
            "targets": -1, // Índice de la quinta columna (columna "Acciones" en un índice basado en cero)
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info BtnCambiar'><i class='fas fa-lock'></i> CAMBIAR CLAVE</button><button class='btn btn-info BtnReestablecer'><i class='fas fa-lock'></i> REESTABLECER CLAVE</button></div><br><div class='btn-group'><button class='btn btn-info BtnFoto'><i class='fas fa-image'></i> FOTO</button><button class='btn btn-primary BtnEditar'><i class='fas fa-edit'></i> EDITAR</button><button class='btn btn-danger BtnBorrar'><i class='fas fa-eraser'></i> BORRAR</button></div></div>"
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
        $("#FormOrganizadores").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Organizador");            
        $("#modalCRUD").modal("show");
        cod_organizador=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón FOTO    
    $(document).on("click", ".BtnFoto", function(){
        fila = $(this).closest("tr");
        cod_organizador = parseInt(fila.find('td:eq(0)').text());
        nombres_usuario = fila.find('td:eq(1)').text();
        apellidos_usuario = fila.find('td:eq(2)').text();
        opcion = 4; //foto
        $.ajax({
            url: "../Modelos/crudOrganizadores.php",
            type: "POST",
            dataType: "json",
            data: { cod_organizador: cod_organizador, opcion: opcion },
            success: function (data) {
                console.log(data);
                if (data == null) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error al cargar la imagen'
                    });
                } else {
                    foto_usuario = data[0].foto_usuario;
                    url = "../img/usuarios/"+foto_usuario;
                    $(".modal-header").css("background-color", "#17a2b8");
                    $(".modal-header").css("color", "white");
                    $(".modal-title").text("Organizador: "+nombres_usuario+" "+apellidos_usuario);
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
        fotoFile = $("#foto_usuario")[0].files[0];
        opcion = 5; // subir foto
        formData = new FormData();
        formData.append("foto_usuario", fotoFile);
        formData.append("cod_organizador", cod_organizador);
        formData.append("opcion", opcion);
        $.ajax({
            url: "../Modelos/crudOrganizadores.php",
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
                    foto_usuario = data[0].foto_usuario;
                    url = "../img/usuarios/"+foto_usuario;
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
    //botón CAMBIAR
    $(document).on("click", ".BtnCambiar", function(){
        fila = $(this);
        cod_organizador = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3;
        Swal.fire({
            title: 'Ingrese su contraseña actual',
            html: `
                <input type="password" id="password" class="swal2-input password-input" minlength="3" maxlength="50" oninput="validarCaracteresEspeciales(this)">
                <span class="toggle-password" onclick="togglePasswordVisibility('password')">Mostrar</span>
                <button id="togglePasswordButton"></button>
            `,
            showCancelButton: true,
            confirmButtonText: 'Verificar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const password = $("#password").val();
                return $.ajax({
                    url: "../Modelos/contraseña.php",
                    type: "POST",
                    dataType: "json",
                    data: { opcion: opcion, password: password, cod_organizador: cod_organizador },
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.value == null) {
                Swal.fire({
                    type: 'error',
                    title: 'Contraseña incorrecta'
                });
                opcion = 0;
            } else {
                Swal.fire({
                    type: 'success',
                    title: 'Contraseña correcta'
                }).then((result) => {
                    opcion = 4;
                    Swal.fire({
                        title: 'Ingrese la nueva contraseña',
                        html: `
                            <input type="password" id="password" class="swal2-input password-input" minlength="3" maxlength="50" oninput="validarCaracteresEspeciales(this)">
                            <span class="toggle-password" onclick="togglePasswordVisibility('password')">Mostrar</span>
                            <button id="togglePasswordButton"></button>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Cambiar',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            const password = $("#password").val();
                            return $.ajax({
                                url: "../Modelos/contraseña.php",
                                type: "POST",
                                dataType: "json",
                                data: { opcion: opcion, password: password, cod_organizador: cod_organizador },
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading(),
                    }).then((result) => {
                        if (result.value == null) {
                            Swal.fire({
                                type: 'error',
                                title: 'Hubo un error al cambiar la contraseña'
                            });
                        } else {
                            Swal.fire({
                                type: 'success',
                                title: 'Cambio de contraseña exitosa'
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                });
            }
        });
    });
    //botón REESTABLECER
    $(document).on("click", ".BtnReestablecer", function(){
        fila = $(this).closest("tr");
        cod_organizador = parseInt(fila.find('td:eq(0)').text());
        opcion = 6; //reestablecer
        $.ajax({
            url: "../Modelos/contraseña.php",
            type: "POST",
            dataType: "json",
            data: { cod_organizador: cod_organizador, opcion: opcion },
            success: function (data) {
                console.log(data);
                if (data == null) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error al reestablecer contraseña'
                    });
                } else {
                    Swal.fire({
                        type: 'success',
                        title: 'Contraseña reestablecida'
                    });
                }
            }
        });
    });
    //botón EDITAR    
    $(document).on("click", ".BtnEditar", function(){
        fila = $(this).closest("tr");
        cod_organizador = parseInt(fila.find('td:eq(0)').text());
        ci_usuario = fila.find('td:eq(1)').text();
        nombres_usuario = fila.find('td:eq(2)').text();
        apellidos_usuario = fila.find('td:eq(3)').text();
        cuenta = fila.find('td:eq(4)').text();
        celular = parseInt(fila.find('td:eq(5)').text());
        correo_usuario = fila.find('td:eq(6)').text();
        carrera = fila.find('td:eq(7)').text();
        rol = fila.find('td:eq(8)').text();
        $("#ci_usuario").val(ci_usuario);
        $("#nombres_usuario").val(nombres_usuario);
        $("#apellidos_usuario").val(apellidos_usuario);
        $("#cuenta").val(cuenta);
        $("#celular").val(celular);
        $("#correo_usuario").val(correo_usuario);
        $("#carrera").val(carrera);
        $("#rol").val(rol);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Organizador");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_organizador = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudOrganizadores.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_organizador:cod_organizador},
                    success: function(){
                        TablaOrganizadores.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormOrganizadores").submit(function(e){
        e.preventDefault();    //evita que se recargue
        ci_usuario = $.trim($("#ci_usuario").val());
        nombres_usuario = $.trim($("#nombres_usuario").val());
        apellidos_usuario = $.trim($("#apellidos_usuario").val());
        cuenta = $.trim($("#cuenta").val());
        celular = $.trim($("#celular").val());
        correo_usuario = $.trim($("#correo_usuario").val());
        carrera = $.trim($("#carrera").val());
        rol = $.trim($("#rol").val());
        if(ci_usuario.lengt == "" || nombres_usuario.length == "" || apellidos_usuario.length == "" || cuenta.length == "" || /*contraseña.length == "" || */celular.length == "" || correo_usuario.length == "" || carrera == "Seleccione una carrera" || rol == "Seleccione un rol"){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudOrganizadores.php",
                type: "POST",
                dataType: "json",
                data: {ci_usuario:ci_usuario, nombres_usuario:nombres_usuario, apellidos_usuario:apellidos_usuario, cuenta:cuenta,/* contraseña:contraseña,*/ celular:celular, correo_usuario:correo_usuario, carrera:carrera, rol:rol, cod_organizador:cod_organizador, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'warning',
                            title: 'Ya existe un organizador registrado con el mismo C.I.'
                        });
                    }else{
                        cod_organizador = data[0].cod_organizador;
                        ci_usuario = data[0].ci_usuario;
                        nombres_usuario = data[0].nombres_usuario;
                        apellidos_usuario = data[0].apellidos_usuario;
                        cuenta = data[0].cuenta;
                        celular = data[0].celular;
                        correo_usuario = data[0].correo_usuario;
                        carrera = data[0].carrera;
                        rol = data[0].rol;
                        if(opcion == 1){TablaOrganizadores.row.add([cod_organizador,ci_usuario,nombres_usuario,apellidos_usuario,cuenta,celular,correo_usuario,carrera,rol]).draw();}
                        else{TablaOrganizadores.row(fila).data([cod_organizador,ci_usuario,nombres_usuario,apellidos_usuario,cuenta,celular,correo_usuario,carrera,rol]).draw();}
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