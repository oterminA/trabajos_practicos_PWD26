
let usuario = document.querySelector(".usuario");
let clave = document.querySelector(".clave");
let boton= document.querySelector(".boton");
let p = document.querySelector(".pVista");
clave.addEventListener('input', noRepetir); //no poner los parentesis ayuda a que no se ejecute desde el inicio la funcion, asi como está se ejecuta cuando tiene que hacerlo
//el input es el evento, no focus o click


function noRepetir(){
    if (clave.value.trim() !== '' && usuario.value.trim() === clave.value.trim()) { //re importante los parentesis en el trim
         p.textContent = "Error, no pueden repetirse";
    } else {
        p.textContent = "";
    }
}

function validarAnio() {
    let bien = true;
    let inputAnio = document.querySelector(".anio");
    let error = document.querySelector(".error");
    let valorAnio = inputAnio.value.trim();

    error.textContent = "";

    if (valorAnio.length !== 4 || isNaN(valorAnio)) {
        error.textContent = "El año debe tener 4 dígitos.";
        bien = false;
    }

    return bien;
}