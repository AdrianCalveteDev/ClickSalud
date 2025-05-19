<?php
    // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos
    require '../../../includes/app.php';

    // Y hacemos uso de las clase Especialidad que usaremos para crearlos
    use App\Especialidad;
    use Intervention\Image\Drivers\Gd\Driver;
    // Libreria de intervetion/image cargada desde composer para la subida de archivos.
    use Intervention\Image\ImageManager as Image;

    autenticar();

    $especialidad = new Especialidad();//$_POST['especialidad']

    // Consulta para obtener todas las especialidades
    $especialidades = Especialidad::all();

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

    include '../../../includes/templates/header.php';
?>

    <main class="formulario">
        <h1>Crear nueva especialidad</h1>

        <a href="/admin/propiedades/especialidades/index.php" class="boton-verde">Volver</a>

        <!-- Fragmento de código PHP para mostrar los errores que contenga el array, si es que tuviese alguno -->
        <?php foreach($errores as $error): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    

        <form class="formulario" method="POST" action="/admin/propiedades/especialidades/crear.php" enctype="multipart/form-data"> <!-- enctype nos permite leer mejor el contenido de los archivos que se envíen desde el formulario --> 
            
            <!-- Incluimos el template del formulario -->
            <?php include '../../../includes/templates/formulario_especialidades.php' ?> 

            <input type="submit" value="Crear Especialidad" class="boton-verde">
        </form>

    </main>

<?php
    include '../../../includes/templates/footer.php';
?>