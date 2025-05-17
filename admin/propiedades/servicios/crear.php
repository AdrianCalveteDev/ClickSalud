<?php
    // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos
    require '../../../includes/app.php';

    // Y hacemos uso de la clase Servicios que usaremos para crearlo
    use App\Servicio;
    use Intervention\Image\Drivers\Gd\Driver;
    // Libreria de intervetion/image cargada desde composer para la subida de archivos.
    use Intervention\Image\ImageManager as Image;

    autenticar();

    $baseDatos = conectarBD(); // Función para conectar la base de datos

    $servicio = new Servicio;

    // Consulta para obtener las especialidades desde base de datos
    $consulta = "SELECT * FROM especialidades";
    $resultadoEspecialidad = mysqli_query($baseDatos, $consulta);

    // Array para almacenar los errores desde el metodo estático de la clase
    $errores = Servicio::getErrores();

    // Comprobamos si el metodo de envío del formulario es de tipo POST
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

            $servicio->guardar();
        }
        
    }

    include '../../../includes/templates/header.php';
?>

    <main class="formulario">
        <h1>Crear nuevo servicio</h1>

        <a href="/admin/propiedades/servicios/index.php" class="boton-verde">Volver</a>

        <!-- Fragmento de código PHP para mostrar los errores que contenga el array, si es que tuviese alguno -->
        <?php foreach($errores as $error): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    

        <form class="formulario" method="POST" action="/admin/propiedades/servicios/crear.php" enctype="multipart/form-data"> <!-- enctype nos permite leer mejor el contenido de los archivos que se envíen desde el formulario --> 
            
            <!-- Incluimos el template del formulario -->
            <?php include '../../../includes/templates/formulario_servicio.php' ?> 

            <input type="submit" value="Crear servicio" class="boton-verde">
        </form>

    </main>

<?php
    include '../../../includes/templates/footer.php';
?>