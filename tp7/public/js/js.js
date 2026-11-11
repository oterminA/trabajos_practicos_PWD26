// paso 3 para usar tom select como libreria

//##RENDER: es una propiedad de tom select que es como una fabrica de plantillas visuales. Sirve para hacer mis propios diseños(etiquetas html, de bootstrap, etc)
//##OPTION: dibuja las opciones individualesque aparecen dentro de la lista desplegable. Muestra las opciones antes de ser elegidas, en el menu. Recibe un data(con value, text, etc) y escape(una funcion de tom select para evitar ataques de inyeccion de codigo xss al imprimir texto del usuario).
//##ITEM: dibuja la etiqueta o pastilla una vez que fue seleccionada.
//##NO_RESULTS: personaliza el msj de 'no results found'.
//##OPTGROUP: para separar las opciones en categorías.


document.addEventListener("DOMContentLoaded", function () {

    const tituloOriginal = document.title;

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            document.title = ' Volvé al catálogo de pelis!! 📽️';
        } else {
            document.title = tituloOriginal;
        }
    });

    ////

    const selectElement = document.querySelector('#select-actores');

    if (selectElement) {

        /////////////////////////////////////para tener imagenes con los nombres
        new TomSelect(selectElement, {
            plugins: ['remove_button'],
            persist: false,
            create: false,
            render: {
                option: function (data, escape) {
                    const nativeOption = this.input.querySelector(`option[value="${data.value}"]`);
                    const fotoUrl = nativeOption ? nativeOption.getAttribute('data-foto') : '';

                    const imgTag = fotoUrl
                        ? `<img src="${fotoUrl}" alt="Foto" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;">`
                        : `<img src="/storage/actores/genetico.png" alt="Sin foto" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;">`;

                    return `<div class="d-flex align-items-center">
                                ${imgTag}
                                <span>${escape(data.text)}</span>
                            </div>`;
                },
                item: function (data, escape) {
                    const nativeOption = this.input.querySelector(`option[value="${data.value}"]`);
                    const fotoUrl = nativeOption ? nativeOption.getAttribute('data-foto') : '';

                    const imgTag = fotoUrl
                        ? `<img src="${fotoUrl}" alt="Foto" class="rounded-circle me-1" style="width: 22px; height: 22px; object-fit: cover;">`
                        : ``;

                    return `<div class="d-flex align-items-center">
                                ${imgTag}
                                <span>${escape(data.text)}</span>
                            </div>`;
                }
            },
            onDelete: function (values) {
                return confirm(values.length > 1 ? 'Estás seguro de borrar los actores?' : 'Estás seguro de borrar el actor?');
            }
        });
    }
});





//DRAG AND DROP creo que usa jquery y podria instalarlo pero sería ir en contra de la ligereza de la libreria
