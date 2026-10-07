let selectL = document.querySelector("#selectEstado");
let form = document.querySelector("#selectEstado");

selectL.addEventListener('change', function () {
    // cuando el select cambie se hace submit en el formulario que seria lo mismo que poner un button type=submit pero se hace acá para poder hacer lo que me parece mejor a mi
    formulario.submit();
});

