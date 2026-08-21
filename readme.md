# Este es el archivo readme de la carpeta de trabajos prácticos de PWD 2026
## El objetivo de la materia es entender cómo se construye una app web, desde elegir el lenguaje hasta dejarla funcionando en un servidor web.

### Cómo manejarse dentro del repositorio
- Por ahora hay un  index.php que tiene un índice a los trabajos prácticos que vamos haciendo en la cursada. Dentro de cada trabajo práctico hay índices también que llevan a cada ejercicio.
Todos los ejercicios pueden volver al inicio de trabajos prácticos.
- Ya sea en apache o ingresando a http://localhost:8000/ levantando el servidor es que se pueden visualizar los trabajos prácticos y ejercicios.

#### Estructura 
- Dentro de la carpeta 'configuracion' existe un script php 'funciones.php' que guarda algunas funciones que se repetían entre los scripts a modo de modularizar un poco el trabajo.
- Los scripts php tienen una primera parte en php donde recupero los datos que llegan desde el formulario a través de POST/GET y los guardo en variables o acomodo según la lógica lo necesite. La segunda parte del script es en html donde armo la vista que se le va a mostrar al usuario con la request que pidió integrando los datos en php.
- Eventualmente se van a ir agregando carpetas referentes al modelo/vista/control y las que traiga Laravel cuando comencemos a usarlo.

### Herramientas usadas
- Por el momento lo que está subido tiene HTML, CSS, JS y PHP. Se conectaron PHP y HTML a través de los formularios usando la propiedad action y method para el envío de los datos.


