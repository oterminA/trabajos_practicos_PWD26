# PWD 2026 - Trabajos Prácticos

## Este repositorio contiene los trabajos prácticos realizados durante la cursada de Programación Web Dinámica (PWD) 2026.

El objetivo de la materia es comprender cómo se construye una aplicación web, desde la elección de las tecnologías hasta su puesta en funcionamiento en un servidor web, incorporando progresivamente nuevas herramientas y conceptos.

### Cómo navegar por el repositorio.

En la raíz del repositorio se encuentra el archivo index.php, que funciona como índice de los trabajos prácticos realizados hasta el TP4. Desde allí se puede acceder a los distintos trabajos y navegar entre sus ejercicios. Cada ejercicio cuenta con una opción para volver al índice de trabajos prácticos.

#### Para visualizar los trabajos prácticos hasta el TP4, se puede levantar el servidor de PHP integrado desde la raíz del repositorio:

*php -S localhost:8000*

#### Luego, ingresar desde el navegador a:

*http://localhost:8000/*

A partir del TP5 cambia la forma de ejecutar los proyectos. Para acceder a los trabajos prácticos desarrollados con Laravel, es necesario ingresar en la carpeta correspondiente a cada TP y levantar su propio servidor utilizando Artisan:

*php artisan serve*

El comando debe ejecutarse desde la carpeta del proyecto Laravel que se desea visualizar. Una vez iniciado el servidor, se debe ingresar a la dirección local que indique la terminal.
Estructura del repositorio

#### El repositorio está organizado para mostrar la evolución de los contenidos y las tecnologías trabajadas durante la cursada.

    * Hasta el TP4: los ejercicios se desarrollan principalmente con HTML, CSS, JavaScript y PHP. Se utiliza index.php como índice general y los formularios permiten enviar información mediante los métodos GET y POST.
    * TP5, TPEloquent y TP6: cada trabajo práctico cuenta con su propio espacio y estructura de proyecto Laravel. Dentro de estas carpetas se encuentran los directorios y archivos correspondientes a cada aplicación, incluidas las dependencias y la estructura generada y administrada por Composer.

*Esta organización es intencional:* cada trabajo práctico conserva una etapa diferente del aprendizaje. De esta manera, es posible recorrer la progresión de los temas vistos en clase y consultar las distintas implementaciones realizadas durante la cursada. Si todos los trabajos se integraran en una única versión de la aplicación, se perdería la posibilidad de observar cómo fueron evolucionando los contenidos y las soluciones a lo largo del tiempo.

### Tecnologías y herramientas utilizadas
A lo largo de la cursada se incorporan distintas tecnologías:

    * HTML y CSS: estructura y presentación de las páginas.
    * JavaScript: incorporación de comportamiento e interactividad en el cliente.
    * PHP: procesamiento de datos y generación de contenido dinámico en los primeros trabajos prácticos.
    * Laravel: framework utilizado a partir del TP5 para desarrollar aplicaciones web con una estructura organizada.
    * Blade: motor de plantillas de Laravel, utilizado para construir las vistas.
    * Eloquent ORM: herramienta de Laravel para trabajar con los datos y las bases de datos mediante modelos.
    * Composer: gestor de dependencias de PHP, utilizado para administrar las librerías y los componentes de los proyectos Laravel.

### Organización del código

En los primeros trabajos prácticos, los scripts PHP procesan los datos recibidos desde los formularios mediante GET o POST y los almacenan en variables para utilizarlos según la lógica de cada ejercicio. Luego, la parte HTML construye la vista que se muestra al usuario, integrando los datos procesados con PHP.

A partir del TP5, se comienza a trabajar con la estructura que propone Laravel, incorporando progresivamente sus herramientas y convenciones. Las responsabilidades del código se organizan utilizando los recursos del framework, entre ellos las rutas, los controladores, las vistas Blade y, en los trabajos que corresponda, los modelos de Eloquent.

Cada proyecto mantiene su propia estructura y sus dependencias para que sea posible estudiar y ejecutar las distintas etapas de manera independiente.

---

**Importante:** para ejecutar los trabajos prácticos desarrollados con Laravel, hay que ubicarse en la carpeta del TP correspondiente antes de utilizar php artisan serve. El servidor iniciado desde la raíz con php -S localhost:8000 permite recorrer el índice y los ejercicios tradicionales hasta el TP4, pero no reemplaza el servidor propio de cada proyecto Laravel.