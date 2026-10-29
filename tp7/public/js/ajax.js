document.addEventListener("DOMContentLoaded", function () { //hago lo del dom para no tener errores con cosass que no se cargan
    //recupero los elementos con los q voy a trabajar
    let formularioSearch = document.querySelector('#formularioSearch');
    let buscador = document.querySelector('#buscar');
    let mostrarResultados = document.querySelector('#mostrar-resultados');

    //esto es para que no funcione el enter porque antes si lo apretaba me aparecia un cartel json medio raro
    if (formularioSearch) {
        formularioSearch.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    }

    //esto supuestamente es para que cancelar automáticamente cualquier petición de búsqueda anterior en cuanto el usuario presiona una nueva tecla (?)
    let abortController = null;

    //esta es la funcion con el listener escuchando el buscador
    if (buscador) {
    buscador.addEventListener('input', async function () {
        let tituloBuscado = this.value; //recupero, entiendo yo, el elemento buscado q viene desde el control
        if (tituloBuscado.trim() === '') { //si el titulo es vacio
            mostrarResultados.replaceChildren();
        } else { //si no es vacio

            if (abortController) { //esto de abort que sigo sin entender cómo estaría funcionando
                abortController.abort();
            }
            abortController = new AbortController();
            try { //uso el try catch para el manejo de eroores
                //acá hago el fetch de la url del ruteo, uso lo de encode para los espacios y
                let response = await fetch(`/api/peliculas/buscar?titulo=${encodeURIComponent(tituloBuscado)}`, {
                    //esto es para cancelar la petición si es necesario
                    signal: abortController.signal
                });
                let data = await response.json(); //acá creo que estoy recuperando el json con la respuesta desde el cntroladro
                if (data.success) { //si es success
                    mostrarResultados.replaceChildren(); //así puedo reemplazar ese espacio con las rtas que obtenga

                    data.peliculas.forEach(pelicula => { //por cada oobjeto pelicula hago un li nuevo y lo sumo al espacio libre en el html
                        const li = document.createElement('li');
                        const a = document.createElement('a');

                        a.href = `/peliculas/${pelicula.id}`;
                        a.textContent = `${pelicula.titulo} (${pelicula.anio})`; //lo muestro así porque me parece que no puedo mostrar el tituloFormateado

                        li.appendChild(a);
                        mostrarResultados.appendChild(li);
                    });
                }
            } catch (error) { //esto es por si falla, asi manejo el error
                if (error.name !== 'AbortError') {
                    console.error('Error en la búsqueda:', error);
                }
            }
        }
    });
    }
});
