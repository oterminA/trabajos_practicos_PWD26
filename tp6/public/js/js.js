// paso 3 para usar tom select como libreria

//##RENDER: es una propiedad de tom select que es como una fabrica de plantillas visuales. Sirve para hacer mis propios diseños(etiquetas html, de bootstrap, etc)
//##OPTION: dibuja las opciones individualesque aparecen dentro de la lista desplegable. Muestra las opciones antes de ser elegidas, en el menu. Recibe un data(con value, text, etc) y escape(una funcion de tom select para evitar ataques de inyeccion de codigo xss al imprimir texto del usuario).
//##ITEM: dibuja la etiqueta o pastilla una vez que fue seleccionada.
//##NO_RESULTS: personaliza el msj de 'no results found'.
//##OPTGROUP: para separar las opciones en categorías.


document.addEventListener("DOMContentLoaded", function () {
    const selectElement = document.querySelector('#select-actores');

    if (selectElement) {
        /////////////////////////////////////para poner el boton de borrar en cada elemento
        // new TomSelect(selectElement, {
        //     plugins: ['remove_button'],
        //     persist: false,
        //     create: false,
        //     onDelete: function (values) {
        //         return confirm(values.length > 1 ? 'Estás seguro de borrar los actores?' : 'Estás seguro de borrar el actor?');
        //     }
        // });

        /////////////////////////////////////para tener un solo boton que borre la eleccion, se usa con elementos solos no multiples
        // new TomSelect(selectElement, {
        //     plugins: {
        //         'clear_button': {
        //             'title': 'Remove all selected options',
        //         }
        //     },
        //     persist: false,
        //     create: false,
        // });

        /////////////////////////////////////para tener un buscador, se usa con elementos solos no multiples
        // new TomSelect(selectElement, {
        //     valueField: 'permalink',
        //     labelField: 'title',
        //     searchField: ['title'],
        //     plugins: ['virtual_scroll'],
        //     maxOptions: 100,

        //     // fetch remote data
        //     firstUrl: function (query) {
        //         return 'https://api.reddit.com/search?q=' + encodeURIComponent(query);
        //     },
        //     load: function (query, callback) {
        //         // retrieve the appropriate url
        //         const url = this.getUrl(query);
        //         fetch(url)
        //             .then(response => response.json())
        //             .then(json => {
        //                 // prepare the next url that will be loaded when the dropdown is scrolled to the bottom
        //                 // important! should set before invoking callback()
        //                 if (json.data.after) {
        //                     const next_url = 'https://api.reddit.com/search?q=' + encodeURIComponent(query) + '&after=' + json.data.after;
        //                     this.setNextUrl(query, next_url);
        //                 }
        //                 // add data to the results
        //                 let data = json.data.children.map(row => row.data);
        //                 callback(data);
        //             }).catch((e) => {
        //                 callback();
        //             });
        //     },
        //     render: {
        //         loading_more: function (data, escape) {
        //             return `<div class="loading-more-results py-2 d-flex align-items-center"><div class="spinner"></div> Loading more results from reddit </div>`;
        //         }
        //     },
        // });

        /////////////////////////////////////para tener un buscador, se usa con elementos solos no multiples
        //     new TomSelect(selectElement, {
        //         options: [
        //             { id: 'avenger', make: 'dodge', model: 'Avenger' },
        //             { id: 'caliber', make: 'dodge', model: 'Caliber' },
        //             { id: 'caravan-grand-passenger', make: 'dodge', model: 'Caravan Grand Passenger' },
        //             { id: 'challenger', make: 'dodge', model: 'Challenger' },
        //             { id: 'ram-1500', make: 'dodge', model: 'Ram 1500' },
        //             { id: 'viper', make: 'dodge', model: 'Viper' },
        //             { id: 'a3', make: 'audi', model: 'A3' },
        //             { id: 'a6', make: 'audi', model: 'A6' },
        //             { id: 'r8', make: 'audi', model: 'R8' },
        //             { id: 'rs-4', make: 'audi', model: 'RS 4' },
        //             { id: 's4', make: 'audi', model: 'S4' },
        //             { id: 's8', make: 'audi', model: 'S8' },
        //             { id: 'tt', make: 'audi', model: 'TT' },
        //             { id: 'avalanche', make: 'chevrolet', model: 'Avalanche' },
        //             { id: 'aveo', make: 'chevrolet', model: 'Aveo' },
        //             { id: 'cobalt', make: 'chevrolet', model: 'Cobalt' },
        //             { id: 'silverado', make: 'chevrolet', model: 'Silverado' },
        //             { id: 'suburban', make: 'chevrolet', model: 'Suburban' },
        //             { id: 'tahoe', make: 'chevrolet', model: 'Tahoe' },
        //             { id: 'trail-blazer', make: 'chevrolet', model: 'TrailBlazer' },
        //         ],
        //         optgroups: [
        //             { $order: 3, id: 'dodge', name: 'Dodge' },
        //             { $order: 2, id: 'audi', name: 'Audi' },
        //             { $order: 1, id: 'chevrolet', name: 'Chevrolet' }
        //         ],
        //         labelField: 'model',
        //         valueField: 'id',
        //         optgroupField: 'make',
        //         optgroupLabelField: 'name',
        //         optgroupValueField: 'id',
        //         lockOptgroupOrder: true,
        //         searchField: ['model'],
        //         plugins: ['optgroup_columns', 'remove_button'], //acá pude combinar este plugin con el de remove_button
        //         openOnFocus: true //esto es para que se despliegue la lista cunado entro en el input
        //     });


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
