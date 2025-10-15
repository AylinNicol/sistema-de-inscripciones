function togglePasswordVisibility(inputId) {
    const passwordInput = document.getElementById(inputId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
function validarCorreo(input) {
    correo = input.value;
    // Verifica si el input es un correo electrónico válido según la especificación del navegador
    if (input.checkValidity()) {
        // En este ejemplo, verifica si el dominio es uno de los permitidos
        dominiosPermitidos = ["gmail.com", "hotmail.com", "yahoo.com"];
        // Extrae el dominio del correo electrónico
        partesCorreo = correo.split("@");
        dominio = partesCorreo[1];
        // Verifica si el dominio está en la lista de dominios permitidos
        if (!dominiosPermitidos.includes(dominio)) {
            Swal.fire({
                type: 'error',
                title: 'El dominio no es válido',
            });
            input.value = "";
        }
    } else {
        Swal.fire({
            type: 'error',
            title: 'Ingrese un correo electrónico válido',
        });
        input.value = "";
    }
}
function convertirMayusculas(input) {
    // Conserva solo letras mayúsculas y espacios
    if (input.value.length >= 3) {
        input.value = input.value.toUpperCase().replace(/[^A-Z\s]/g, '');
    }
}
function validarLetras(input) {
    // Conserva solo letras mayúsculas y espacios
    if (input.value.length >= 3) {
        input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    }
}
function validarNumeros(input) {
    // Elimina cualquier carácter que no sea un número
    input.value = input.value.replace(/[^0-9]/g, '');
}
function validarCosto(input) {
    // Elimina cualquier carácter que no sea un número
    input.value = input.value.replace(/[^0-9.]/g, '');
    // Verifica si hay más de un punto decimal y elimina los extras
    let puntoDecimalCount = (input.value.match(/\./g) || []).length;
    if (puntoDecimalCount > 1) {
        // Si hay más de un punto, elimina los extras
        input.value = input.value.replace(/\.(?=.*\.)/g, '');
    }
}
function validarLetrasyNumeros(input) {
    // Elimina cualquier carácter que no sea una letra, número, coma, punto y coma, guión o espacio
    if (input.value.length >= 15) {
        input.value = input.value.replace(/[^A-Za-z0-9,;.\-\s]/g, '');
    }
}
function validarCaracteresEspeciales(input) {
    // Elimina cualquier carácter que no sea una letra, número, espacio o los caracteres especiales permitidos
    if (input.value.length >= 3) {
        input.value = input.value.replace(/[^A-Za-z0-9\s_,;\-.!#$%&\/@]/g, '');
    }
}
