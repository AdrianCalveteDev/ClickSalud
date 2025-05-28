<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $funcion)
    {
        $this->rutasGET[$url] = $funcion;
    }

    public function post($url, $funcion)
    {
        $this->rutasPOST[$url] = $funcion;
    }

    public function comprobarRutas()
    {   
        session_start();
        $auth = $_SESSION['login'] ?? null;

        // Array para rutas protegidas
        $rutasProtegidas = ['/admin', '/servicios/admin', '/servicios/crear', '/servicios/actualizar', '/servicios/eliminar', '/especialidades/admin', '/especialidades/crear', '/especialidades/actualizar', '/especialidades/eliminar'];


        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodoHttp = $_SERVER['REQUEST_METHOD'];

        // Si el metodo es GET llamamos a la función get definida arriba
        if ($metodoHttp === 'GET'){
            $funcion = $this->rutasGET[$urlActual] ?? null;
            // Y si no, llamamos a la función post
        } else {
            $funcion = $this->rutasPOST[$urlActual] ?? null;
        }

        // Proteger las rutas

        // Si la url actual se encuentra dentro del array de rutas protegidas pero no está autenticado, le redirigimos a la página principal con el fin de proteger las rutas
        if(in_array($urlActual, $rutasProtegidas) && !$auth){
            header('Location: /');
        }

        if($funcion){
            // La URL existe y hay una función asociada
            call_user_func($funcion, $this); // Llamamos a la función aunque no sabemos como se llama
        } else {
            // La URL no existe, mostramos al usuario un mensaje de error
            echo "Página no encontrada";
        }
    }

    // Mostrar una vista
    public function render($view, $datos = [])
    {   
        foreach ($datos as $llave => $valor){
            $$llave = $valor; // Como no sabemos el nombre que van a tener los datos, definimos la llave como variable de variable
        }
        // Iniciamos almacenamiento en memoria que es lo que vamos a renderizar
         ob_start();
        include __DIR__ . "/views/$view.php";

        // Limpiamos la memoria tras renderizar
         $contenido = ob_get_clean();

        // Incluimos en el render el layout base que contiene el header y el footer
        include __DIR__ . "/views/layout.php";
    }
}