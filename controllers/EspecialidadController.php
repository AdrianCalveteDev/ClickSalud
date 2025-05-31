<?php

namespace Controllers;
use MVC\Router;
use Model\Especialidad;
use Intervention\Image\Drivers\Gd\Driver;
// Libreria de intervetion/image cargada desde composer para la subida de archivos.
use Intervention\Image\ImageManager as Image;

class EspecialidadController {

    public static function index(Router $router){

        $especialidades = Especialidad::all();

        $resultado = $_GET['resultado'] ?? null;

        $router->render('especialidades/admin', [
            'especialidades' => $especialidades,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router){
        $especialidad = new Especialidad();

        // Array para almacenar los errores desde el metodo estático de la clase
        $errores = Especialidad::getErrores();

        // Comprobamos si el metodo de envío del formulario es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Creamos una instancia de nuestra clase Especialidad
            $especialidad = new Especialidad($_POST['especialidad']);

            // A la imágen que va a subir nuestro usuario le debemos asignar un nombre único para que no coincida nunca con otras
            // imágenes que pueden subir otros usuarios. Lo hacemos generando un número unico, randomizado y hasheado (md5)
            $nombreImagenEspecialidad = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['especialidad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['especialidad']['tmp_name']['imagen'])->cover(800, 600);
                $especialidad->setImagen($nombreImagenEspecialidad);
            }
            // Lo mismo para los logos
            $nombreLogoEspecialidad = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['especialidad']['tmp_name']['logo']){
                $manager = new Image(Driver::class);
                $logo = $manager->read($_FILES['especialidad']['tmp_name']['logo'])->cover(256, 256);
                $especialidad->setLogo($nombreLogoEspecialidad);
            }

            // Asignamos a una variable errores nuestro metodo getter estatico para recoger los errores de validación
            $errores = $especialidad->validar();

            // Miramos que el arreglo de los errores esté vacío con el método empty de PHP y si está vacío ejecutamos la query contra la BBDD
            if(empty($errores)){

                /* Para la subida de imágenes */

                // Si la carpeta principal no existe, la creamos
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
                // Si la carpeta para almacenar las imagenes de especialidades no existe, la creamos
                if(!is_dir(CARPETA_IMAGENES_ESPECIALIDADES)){
                    mkdir(CARPETA_IMAGENES_ESPECIALIDADES);
                }

                // Guardar la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES_ESPECIALIDADES . $nombreImagenEspecialidad);
                // Guardar el logo en el servidor
                $logo->save(CARPETA_IMAGENES_ESPECIALIDADES . $nombreLogoEspecialidad);

                // Guardamos la información y le pasamos en el parametro la ruta donde se mostrará el error
                $especialidad->guardar(MENSAJES_ESPECIALIDADES);
            }   
        }

        $router->render('especialidades/crear', [
            'especialidad' => $especialidad,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){

        $id = validarORedireccionar('/admin');

        // Obtenemos los datos del servicio
        $especialidad = Especialidad::buscar($id);

        // Array para almacenar los errores
        $errores = Especialidad::getErrores();

        // Comprobamos si el metodo de envío del formulario es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Asignar los atributos al array
            $args = $_POST['especialidad'];

            // Utilizamos la función sincronizar de nuestra clase servicios para pasarle el array con los atributos y almacenarlos en BBDD
            $especialidad->sincronizar($args);

            // Subida de imagenes
            $nombreImagenEspecialidad = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['especialidad']['tmp_name']['imagen']){
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['especialidad']['tmp_name']['imagen'])->cover(800, 600);
                $especialidad->setImagen($nombreImagenEspecialidad);
            }
            // Lo mismo para los logos
            $nombreLogoEspecialidad = md5(uniqid(rand(), true)) . ".jpg";
            if($_FILES['especialidad']['tmp_name']['logo']){
                $manager = new Image(Driver::class);
                $logo = $manager->read($_FILES['especialidad']['tmp_name']['logo'])->cover(256, 256);
                $especialidad->setLogo($nombreLogoEspecialidad);
            }

            // Validación de los campos
            $errores = $especialidad->validar();

            // Miramos que el arreglo de los errores esté vacío con el método empty de PHP y si está vacío ejecutamos la query contra la BBDD
            if(empty($errores)){
                // Guardar la imagen
                if($_FILES['especialidad']['tmp_name']['imagen']){
                    $imagen->save(CARPETA_IMAGENES_ESPECIALIDADES . $nombreImagenEspecialidad);
                }
                // Guardar el logo
                if($_FILES['especialidad']['tmp_name']['logo']){
                    $logo->save(CARPETA_IMAGENES_ESPECIALIDADES. $nombreLogoEspecialidad);
                }
                
                // Guardar la actualización en la base de datos
                $especialidad->guardar(MENSAJES_ESPECIALIDADES);
            }
        }

        $router->render('especialidades/actualizar', [
            'especialidad' => $especialidad,
            'errores' => $errores
        ]);
    }

    public static function eliminar(){
        // Cuando se envíe el formulario de eliminar, asignamos a la variable el ID del servicio
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idEspecialidad = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if($idEspecialidad){
                // Obtenemos los datos del especialidad
                $especialidad = Especialidad::buscar($idEspecialidad);
                // Eliminamos la especialidad
                $especialidad->eliminar(MENSAJES_ESPECIALIDADES);        
            }   
        }
    }
}