<?php
    // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos

    use App\Servicio;
    use Intervention\Image\Drivers\Gd\Driver;
    // Libreria de intervetion/image cargada desde composer para la subida de archivos.
    use Intervention\Image\ImageManager as Image;

    require '../../../includes/app.php';

    autenticar();
    

    // Variable con el ID del servicio, donde nos aseguramos de que solo pueda ser un dato de tipo integer
    // Esto evita que alguien intente pasar un dato no valido, evita SQL injection y XSS
    $idServicio = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Si se pasa un dato que no es un INT, redirigimos al usuario al panel de administración de los servicios.
    if (!$idServicio){
        header('Location: /admin/propiedades/servicios/index.php');
    }

    // Obtenemos los datos del servicio
    $servicio = Servicio::buscarServicio($idServicio);

    // Consulta para obtener las especialidades desde base de datos
    $consulta = "SELECT * FROM especialidades";
    $resultadoEspecialidad = mysqli_query($baseDatos, $consulta);

    // Array para almacenar los errores
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
            $servicio->guardar();
        }
        
    }

    include '../../../includes/templates/header.php';
?>

    <main class="formulario">
        <h1>Actualizar servicio</h1>

        <a href="/admin/propiedades/servicios/index.php" class="boton-verde">Volver</a>

        <!-- Fragmento de código PHP para mostrar los errores que contenga el array, si es que tuviese alguno -->
        <?php foreach($errores as $error): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    

        <form class="formulario" method="POST" enctype="multipart/form-data"> <!-- enctype nos permite leer mejor el contenido de los archivos que se envíen desde el formulario --> 
        
            <!-- Incluimos el template del formulario -->
            <?php include '../../../includes/templates/formulario_servicio.php' ?> 

            <input type="submit" value="Actualizar servicio" class="boton-verde">
        </form>

    </main>

<?php
    include '../../../includes/templates/footer.php';
?>