function comprobar() {
  let email=document.getElementById('user').value;
  let contrasenya=document.getElementById('password').value;
  if(email.length==0){
    document.getElementById('errorEmail').textContent = "Es obligatorio introducir el correo";
    if (contrasenya.length==0) {
      document.getElementById('errorContrasenya').textContent = "Es obligatorio introducir la contraseña";
    }
  }
  else {
    return true;
   
  }
}