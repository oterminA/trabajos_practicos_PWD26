///acá quiero manejar lo de ajax

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
    if (buscador) { //puse el if xq me daba error con el otro ajax, entonces reviso que este elemento exista asi no me da error
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


    /////////////////////////////////////lo del 'bot' de preguntas
    //recupero los elmeentos del layout
    const toggleBtn = document.getElementById('chat-toggle');
    const closeBtn = document.getElementById('chat-close');
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMensajes = document.getElementById('chat-mensajes');

    //eventos relacionados a cerrar y abrir el bot y que aparezcan/desaparezcan las cosas
    toggleBtn.addEventListener('click', () => {
        chatBox.style.display = 'flex';
        toggleBtn.style.display = 'none';
    });
    closeBtn.addEventListener('click', () => {
        chatBox.style.display = 'none';
        toggleBtn.style.display = 'block';
    });


    //estoes para cuando el usuario envia la pregunta o mensaje
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault(); //para evitar q se recargue cada vez q se hace el submit
        let mensajeTexto = chatInput.value; //recupero el texto q puso el usuario

        chatMensajes.innerHTML += `<p><strong>Tú:</strong> ${mensajeTexto}</p>`; //acá armo el msj de lo que pregunta el user
        chatInput.value = '';
        chatMensajes.scrollTop = chatMensajes.scrollHeight;

        //empieza el ajax
        fetch('/chat/enviar', { //la ruta del fetch
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ mensaje: mensajeTexto }) //pasa el texto a json
        })
            .then(response => response.json())
            .then(data => { //acá se arma lo que es la respuesta dewl bot
                chatMensajes.innerHTML += `<p class="text-primary"><strong>PeliBot:</strong> ${data.respuesta}</p>`;
                chatMensajes.scrollTop = chatMensajes.scrollHeight;
            })
            .catch(error => { //el catch del error por si hay alguno
                console.error('Error:', error);
                chatMensajes.innerHTML += `<p class="text-danger"><strong>Error:</strong> No se pudo conectar con el asistente.</p>`;
            });
    });
});
