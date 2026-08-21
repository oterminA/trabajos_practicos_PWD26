
let usuario = document.querySelector(".usuario");
let clave = document.querySelector(".clave");
let boton= document.querySelector(".boton");
let p = document.querySelector(".pVista");
boton.addEventListener('click',noRepetir());


function noRepetir(){
    if ((usuario.value !== '') && (clave.value !== '') && usuario.value !== clave.value) {
        p.textContent = "";
    }else{
        p.textContent = "Error, no pueden repetirse";
    }
}