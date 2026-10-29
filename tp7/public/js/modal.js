//codigo q tiene lo del modal y el ajax asociado a la creacion de reseña

function abrirModalResenia(boton) {
    const peliculaId = boton.getAttribute('data-pelicula-id'); //recuero el id de la peli

    Swal.fire({ //acá empieza lo de sweetalert2
        title: 'Dejar reseña',
        html: `
            <textarea id="swal-comentario" class="swal2-textarea" placeholder="Comentario"></textarea>
            <input type="number" id="swal-puntaje" class="swal2-input" min="1" max="5" placeholder="Puntaje (1 al 5)">
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Publicar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#379b37',
        cancelButtonColor: '#6c757d',
        preConfirm: () => {
            const comentario = document.getElementById('swal-comentario').value;
            const puntaje = document.getElementById('swal-puntaje').value;

            if (!comentario || !puntaje) {
                Swal.showValidationMessage('Por favor completá todos los campos');
            }

            return {
                comentario: comentario,
                puntaje: puntaje,
                pelicula_id: peliculaId
            }
        }
    }).then((result) => {
        if (result.isConfirmed) { //si se pudo hacer lo del modal
            const datos = result.value;

            fetch(`/api/resenias-pelicula/crear/${peliculaId}`, { //acá empieza lo de ajax, esta es la url de la ruta
                method: 'POST', //post porque estoy modificando el servidor
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') //entiendo que tengo que poner esto porque es un formulario y sino laravel no me deja + tuve q poner un coso en el head del layout pelicula
                },
                body: JSON.stringify(datos) //paso los datos a json
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Reseña publicada',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else { //si hubo un error al guardar la reseña
                    Swal.fire('Error', 'No se pudo guardar la reseña.', 'error');
                }
            }) //por si hay un error para manejar
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error inesperado.', 'error');
            });
        }
    });
}
