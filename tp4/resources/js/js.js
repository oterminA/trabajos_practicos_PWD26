
// recupero las variables que voy a necesitar
let select = document.querySelector("#selectGenero");
let formulario = document.querySelector("#formGenero");

select.addEventListener('change', function () {
    // cuando el select cambie se hace submit en el formulario que seria lo mismo que poner un button type=submit pero se hace acá para poder hacer lo que me parece mejor a mi
    formulario.submit();
});
