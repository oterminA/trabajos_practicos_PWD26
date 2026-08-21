<!-- Ejercicio 5
Modificar el formulario del ejercicio anterior solicitando, tal que usando componentes
“radios buttons” se ingrese el nivel de estudio de la persona: 1-no tiene estudios, 2-
estudios primarios, 3-estudios secundarios. Agregar el componente que crea más
apropiado para solicitar el sexo. En la página que procesa el formulario mostrar además
un mensaje que indique el tipo de estudios que posee y su sexo. -->
    <link rel="stylesheet" href="/css/style.css">
    <title>Ejercicio 5</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Ejercicio n° 5</h1>
            <h2>Completá los datos</h2>
            <form action="mostrardatos.php" method="POST" class="form-contenedor">
                <label>Nombre:</label>
                <input type="text" name="nombre" required max="10">
                <label>Apellido</label>
                <input type="text" name="apellido" required max="20">
                <label>Edad</label>
                <input type="number" name="edad" required>
                <label>Direccion</label>
                <input type="text" name="direccion" required max="50">
                <label>Genero</label>  
                <select name="genero">
                    <option value="">Seleccione una opcion</option>
                    <option value="F">F</option>
                    <option value="M">M</option>
                    <option value="OTRO">OTRO</option>
                </select>
                <label>Nivel de estudios</label>  
                <label for="">Sin estudios</label>
                <input type="radio" name="est" id="sin_est" value="sin_est" required>
                <label for="">Primario </label>
                <input type="radio" name="est" id="est_prim" value="est_prim" required>
                <label for="">Secundario</label>
                <input type="radio" name="est" id="est_sec" value="est_sec" required> 
                <label for="">Universitario</label>
                <input type="radio" name="est" id="est_uni" value="est_uni" required>  

                <button type="reset" class="btn-borrar">Limpiar campos</button>
                <button type="submit" class="btn-enviar">Mostrar datos</button>
            <a href="/tp1/inicio_tp1.php" class="btn-volver">Volver al índice de ejercicios</a>
            </form>

        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>