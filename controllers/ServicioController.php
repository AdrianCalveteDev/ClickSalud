<?php

namespace Controllers;
use MVC\Router;
use Model\Servicio;
use Model\Especialidad;
use Intervention\Image\Drivers\Gd\Driver;
// Libreria de intervetion/image cargada desde composer para la subida de archivos.
use Intervention\Image\ImageManager as Image;

class ServicioController {

    public static function dashboard(Router $router) {
        $autenticado = $_SESSION['login'] ?? false;

        $router->render('admin');
    }

    public static function index(Router $router){

        $servicios = Servicio::all();

        $resultado = $_GET['resultado'] ?? null;

        $router->render('servicios/admin', [
            'servicios' => $servicios,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router){
        $servicio = new Servicio;
        $especialidades = Especialidad::all();
        // Array para almacenar los errores desde el metodo estático de la clase
        $errores = Servicio::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Creamos una instancia de nuestra clase Servicio
            $servicio = new Servicio($_POST['servicio']);

            // A la imágen que va a subir nuestro usuario le debemos asignar un nombre único para que no coincida nunca con otras
            // imágenes que pueden subir otros usuarios. Lo hacemos generando un número unico, randomizado y hasheado (md5)
            $nombreImagenServicio = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['servicio']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['servicio']['tmp_name']['imagen'])->cover(800, 600);
                $servicio->setImagen($nombreImagenServicio);
            }

            // Asignamos a una variable errores nuestro metodo getter estatico para recoger los errores de validación
            $errores = $servicio->validar();

            // Miramos que el arreglo de los errores esté vacío con el método empty de PHP y si está vacío ejecutamos la query contra la BBDD
            if(empty($errores)){

                /* Para la subida de imágenes */

                // Si la carpeta principal no existe, la creamos
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
                // Si la carpeta para almacenar las imagenes de servicios no existe, la creamos
                if(!is_dir(CARPETA_IMAGENES_SERVICIOS)){
                    mkdir(CARPETA_IMAGENES_SERVICIOS);
                }

                // Guardar la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES_SERVICIOS . $nombreImagenServicio);

                $servicio->guardar(MENSAJES_SERVICIOS);
            }
        }

        $router->render('servicios/crear', [
            'servicio' => $servicio,
            'especialidades' => $especialidades,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');

        $servicio = Servicio::buscar($id);
        $especialidades = Especialidad::all();
        $errores = Servicio::getErrores();

        // Comprobamos si el metodo de envío del formulario es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Asignar los atributos al array
            $args = $_POST['servicio'];

            // Utilizamos la función sincronizar de nuestra clase servicios para pasarle el array con los atributos y almacenarlos en BBDD
            $servicio->sincronizar($args);

            // Validación de los campos
            $errores = $servicio->validar();

            // A la imágen que va a subir nuestro usuario le debemos asignar un nombre único para que no coincida nunca con otras
            // imágenes que pueden subir otros usuarios. Lo hacemos generando un número unico, randomizado y hasheado (md5)
            $nombreImagenServicio = md5(uniqid(rand(), true)) . ".jpg";

            // Subida de imagenes
            if($_FILES['servicio']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['servicio']['tmp_name']['imagen'])->cover(800, 600);
                $servicio->setImagen($nombreImagenServicio);
            }

            // Miramos que el arreglo de los errores esté vacío con el método empty de PHP y si está vacío ejecutamos la query contra la BBDD
            if(empty($errores)){
                // Guardar la imagen
                if($_FILES['servicio']['tmp_name']['imagen']){
                    $imagen->save(CARPETA_IMAGENES_SERVICIOS . $nombreImagenServicio);
                }
                
                // Guardar la actualización en la base de datos
                $servicio->guardar(MENSAJES_SERVICIOS);
            }
        }

        $router->render('servicios/actualizar', [
            'servicio' => $servicio,
            'especialidades' => $especialidades,
            'errores' => $errores
        ]);
    }

    public static function eliminar(){
        // Cuando se envíe el formulario de eliminar, asignamos a la variable el ID del servicio
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idServicio = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if($idServicio){
                // Obtenemos los datos del servicio
                $servicio = Servicio::buscar($idServicio);
                $servicio->eliminar(MENSAJES_SERVICIOS);        
            }   
        }
    }
}