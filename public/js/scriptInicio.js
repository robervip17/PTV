document.addEventListener('DOMContentLoaded', () => {
    let frases=new Array()
    frases[0] = '"Desde 1988 trabajando por y para los conductores."'; 
    frases[1] = '"Tu taller de confianza."'; 
    frases[2] = '"Un grupo de profesionales"'; 
    frases[3] = '"Estamos para arreglar tu vehiculo"'; 
    frases[4] = '"Mejor taller, calidad - precio..."';

    let x = frases.length; 
    let whichFrase=Math.round(Math.random()*(x-1)); 
    let fraseAle = document.getElementById('fraseAle');
    fraseAle.innerHTML = frases[whichFrase];

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