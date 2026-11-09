//codigo q tiene lo del modal y el ajax asociado a la creacion de reseña
async function abrirModalResenia(boton) {
    const peliculaId = boton.getAttribute('data-pelicula-id');

    // sweetAlert2 maneja promesas, así que también puedo usar await para esperar el resultado
    const result = await Swal.fire({
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
            };
        }
    });

    //si el user confirmó el modal hago el fetch de ajax
    if (result.isConfirmed) {
        const datos = result.value;

        try {
            const response = await fetch(`/api/resenias-pelicula/crear/${peliculaId}`, {
                method: 'POST', //post xq estoy modificando elementos de la base de datos
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') //esto es x seguridad de laravel
                },
                body: JSON.stringify(datos) //para pasaar a json los datos
            });

            const data = await response.json();

            if (data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Reseña publicada',
                    timer: 1000, //esto representa el tiempo en que se muestra el cartelito de success o sea cuánto tiempo se mantiene
                    showConfirmButton: false
                });

                setTimeout(() => {
                    location.reload();
                }, 100); //esto representa el tiempo que se tarda en 'recargar' la pagina o sea en cuanto tiempo aparece la reseña agregada recien
            } else {
                Swal.fire('Error', 'No se pudo guardar la reseña.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Ocurrió un error inesperado.', 'error');
        }
    }
}
