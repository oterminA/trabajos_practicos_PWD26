
let usuario = document.querySelector(".usuario");
let clave = document.querySelector(".clave");
let boton = document.querySelector(".boton");
let p = document.querySelector(".pVista");
clave.addEventListener('input', noRepetir); //no poner los parentesis ayuda a que no se ejecute desde el inicio la funcion, asi como está se ejecuta cuando tiene que hacerlo
//el input es el evento, no focus o click


function noRepetir() {
    if (clave.value.trim() !== '' && usuario.value.trim() === clave.value.trim()) { //re importante los parentesis en el trim
        p.textContent = "Error, no pueden repetirse";
    } else {
        p.textContent = "";
    }
}

//para lo del tooltip en el h2
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

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

function validarArchivo() {
    let bien = true;
    let archivo = document.querySelector(".archivo");
    let error = document.querySelector(".error");
    let tamanio = 2 * 1024 * 1024; //o sea los 2mb
    error.textContent = "";
    if (archivo.files.length > 0) {
        let file = archivo.files[0];

        if (file.size > tamanio) {
            error.textContent = "El tamaño del archivo no puede superar los 2mb";
            bien = false;
        } else {
            error.textContent = " ";
        }
    }
    return bien;
}


function validarImagen() {
    //valido el tamaño de la imagen
    let bien = true;
    let archivo = document.querySelector(".portada");
    let textoImagen = document.querySelector(".textoImagen");
    let tamanio = 300 * 1024; //o sea los 300kb
    textoImagen.textContent = "";
    if (archivo.files.length > 0) {
        let file = archivo.files[0];

        if (file.size > tamanio) {
            textoImagen.textContent = "El tamaño de la imagen no puede superar los 300KB";
            bien = false;
        } else {
            textoImagen.textContent = " ";
        }
    }
}