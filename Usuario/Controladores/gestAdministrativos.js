$(document).ready(function(){
    TablaAdministrativos = $("#TablaAdministrativos").DataTable({
        "columnDefs":[
            { "width": "5%", "targets": 0 },
            { "width": "7%", "targets": 1 },
            { "width": "10%", "targets": 2 },
            { "width": "10%", "targets": 3 },
            { "width": "8%", "targets": 4 },
            { "width": "5%", "targets": 5 },
            { "width": "12%", "targets": 6 },
            { "width": "8%", "targets": 7 },
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
        $("#FormAdministrativos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Administrativo");            
        $("#modalCRUD").modal("show");
        cod_administrativo=null;
        opcion = 1; //alta
    });
    var fila; //capturar la fila para editar o borrar el registro
    //botón FOTO    
    $(document).on("click", ".BtnFoto", function(){
        fila = $(this).closest("tr");
        cod_administrativo = parseInt(fila.find('td:eq(0)').text());
        nombres_usuario = fila.find('td:eq(2)').text();
        apellidos_usuario = fila.find('td:eq(3)').text();
        opcion = 4; //foto
        $.ajax({
            url: "../Modelos/crudAdministrativos.php",
            type: "POST",
            dataType: "json",
            data: { cod_administrativo: cod_administrativo, opcion: opcion },
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
                    $(".modal-title").text("Administrativo: "+nombres_usuario+" "+apellidos_usuario);
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
        formData.append("cod_administrativo", cod_administrativo);
        formData.append("opcion", opcion);
        $.ajax({
            url: "../Modelos/crudAdministrativos.php",
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
        cod_administrativo = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 1;
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
                    data: { opcion: opcion, password: password, cod_administrativo: cod_administrativo },
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
                    opcion = 2;
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
                                data: { opcion: opcion, password: password, cod_administrativo: cod_administrativo },
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
        cod_administrativo = parseInt(fila.find('td:eq(0)').text());
        opcion = 5; //reestablecer
        $.ajax({
            url: "../Modelos/contraseña.php",
            type: "POST",
            dataType: "json",
            data: { cod_administrativo: cod_administrativo, opcion: opcion },
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
        cod_administrativo = parseInt(fila.find('td:eq(0)').text());
        ci_usuario = fila.find('td:eq(1)').text();
        nombres_usuario = fila.find('td:eq(2)').text();
        apellidos_usuario = fila.find('td:eq(3)').text();
        cuenta = fila.find('td:eq(4)').text();
        cargo = fila.find('td:eq(5)').text();
        correo_usuario = fila.find('td:eq(6)').text();
        fecha_nac = fila.find('td:eq(7)').text();
        $("#ci_usuario").val(ci_usuario);
        $("#nombres_usuario").val(nombres_usuario);
        $("#apellidos_usuario").val(apellidos_usuario);
        $("#cuenta").val(cuenta);
        $("#cargo").val(cargo);
        $("#correo_usuario").val(correo_usuario);
        $("#fecha_nac").val(fecha_nac);
        opcion = 2; //editar
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Administrativo");            
        $("#modalCRUD").modal("show");
    });
    //botón BORRAR
    $(document).on("click", ".BtnBorrar", function(){
        fila = $(this);
        cod_administrativo = parseInt($(this).closest("tr").find('td:eq(0)').text());
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
                    url: "../Modelos/crudAdministrativos.php",
                    type: "POST",
                    dataType: "json",
                    data: {opcion:opcion, cod_administrativo:cod_administrativo},
                    success: function(){
                        TablaAdministrativos.row(fila.parents('tr')).remove().draw();
                    }
                });
            }
        });
    });
    $("#FormAdministrativos").submit(function(e){
        e.preventDefault();    //evita que se recargue
        ci_usuario = $.trim($("#ci_usuario").val());
        nombres_usuario = $.trim($("#nombres_usuario").val());
        apellidos_usuario = $.trim($("#apellidos_usuario").val());
        cuenta = $.trim($("#cuenta").val());
        cargo = $.trim($("#cargo").val());
        correo_usuario = $.trim($("#correo_usuario").val());
        fecha_nac = $.trim($("#fecha_nac").val());
        if(ci_usuario.lengt == "" || nombres_usuario.length == "" || apellidos_usuario.length == "" || cuenta.length == "" || /*contraseña.length == "" || */cargo.length == "" || correo_usuario.length == "" || fecha_nac.length == ""){ //.length es la cantidad de caracteres
            Swal.fire({
              type: 'warning',
              title: 'Ingrese los datos',
            });
            return false;
        }else{
            $.ajax({
                url: "../Modelos/crudAdministrativos.php",
                type: "POST",
                dataType: "json",
                data: {ci_usuario:ci_usuario, nombres_usuario:nombres_usuario, apellidos_usuario:apellidos_usuario, cuenta:cuenta, /*contraseña:contraseña, */cargo:cargo, correo_usuario:correo_usuario, fecha_nac:fecha_nac, cod_administrativo:cod_administrativo, opcion:opcion},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        Swal.fire({
                            type: 'warning',
                            title: 'Ya existe un administrativo registrado con el mismo C.I.'
                        });
                    }else{
                        cod_administrativo = data[0].cod_administrativo;
                        ci_usuario = data[0].ci_usuario;
                        nombres_usuario = data[0].nombres_usuario;
                        apellidos_usuario = data[0].apellidos_usuario;
                        cuenta = data[0].cuenta;
                        cargo = data[0].cargo;
                        correo_usuario = data[0].correo_usuario;
                        fecha_nac = data[0].fecha_nac;
                        if(opcion == 1){TablaAdministrativos.row.add([cod_administrativo,ci_usuario,nombres_usuario,apellidos_usuario,cuenta,cargo,correo_usuario,fecha_nac]).draw();}
                        else{TablaAdministrativos.row(fila).data([cod_administrativo,ci_usuario,nombres_usuario,apellidos_usuario,cuenta,cargo,correo_usuario,fecha_nac]).draw();}
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