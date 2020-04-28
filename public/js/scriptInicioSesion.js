function comprobar() {
  let email=document.getElementById('envio_inicio_sesion_dni').value;
  let contrasenya=document.getElementById('envio_inicio_sesion_password').value;
  if(email.length==0){
    document.getElementById('errorEmail').textContent = "Es obligatorio introducir el DNI";
    if (contrasenya.length==0) {
      document.getElementById('errorPassword').textContent = "Es obligatorio introducir la contraseña";
    }
  }
  else {
    return true;
   
  }
}