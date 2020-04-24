document.addEventListener('DOMContentLoaded', () => {
    let boton1PopUp = document.getElementById('boton1');

    if (boton1PopUp) {
        boton1PopUp.addEventListener('click', cancelarScroll);
    }
    
    function cancelarScroll() {
        let body = document.getElementsByTagName("BODY")[0];
        body.style.overflow = 'hidden';
    }

    let cerrar = document.getElementById('cerrar');

    cerrar.addEventListener('click', ponerSrcoll);


    function ponerSrcoll() {
        let body = document.getElementsByTagName("BODY")[0];
        body.style.overflow = 'auto';
    }

});