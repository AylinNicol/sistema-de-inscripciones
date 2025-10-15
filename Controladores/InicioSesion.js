$("#FormLogin").submit(function(e){
    e.preventDefault(); // evita que se recargue la pagina
    usuario = $.trim($("#Usuario").val()); //trim sirve para eliminar espacios innecesarios
    password = $.trim($("#Password").val());
    if(usuario.length == "" || password.length == ""){ //.length es la cantidad de caracteres
        Swal.fire({
          type: 'warning',
          title: 'Ingrese Usuario y/o Password',
        });
        $("#FormLogin").trigger("reset");
        return false;
    }else{
        $.ajax({
            url: "./Modelos/login.php",
            type: "POST",
            dataType: "json",
            data:  {usuario:usuario, password:password}, 
            success: function(data) {
                console.log(data);
                if(data == null){
                    Swal.fire({
                        type: 'error',
                        title: 'Usuario y/o Password incorrectas'
                    });
                    $("#FormLogin").trigger("reset");
                }else{
                    Swal.fire({
                        type: 'success',
                        title: '¡Ingreso exitoso!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'INGRESAR'
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = "./Usuario/inicioOrganizador.php";
                        }
                    });
                    $("#FormLogin").trigger("reset");
                }
            }
        });
    }
});