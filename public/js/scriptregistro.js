function comprobar() { 
    let nomApe = document.getElementById('envio_registro_nombreCompleto').value;
    let dni = document.getElementById('envio_registro_dni').value;
    let email = document.getElementById('envio_registro_email').value;
    let contrasenya = document.getElementById('envio_registro_password').value;
    
    if (nomApe.length == 0) {
        document.getElementById('errorCredenciales').textContent = "Es obligatorio rellenar todos los campos";
    }
    if (dni.length == 0) {
        document.getElementById('errorCredenciales').textContent = "Es obligatorio rellenar todos los campos";
    }
    if (email.length == 0) {
        document.getElementById('errorCredenciales').textContent = "Es obligatorio rellenar todos los campos";
    }
    if (contrasenya.length == 0) {
        document.getElementById('errorCredenciales').textContent = "Es obligatorio rellenar todos los campos";
    }
    else {
        return true;

    }
}
