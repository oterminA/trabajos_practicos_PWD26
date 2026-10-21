// paso 3 para usar tom select como libreria
document.addEventListener("DOMContentLoaded", function() {
        new TomSelect("#select-actores", {
            create: false, // evita q el usuario escriba actores nuevos que no existan en la bd
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });
