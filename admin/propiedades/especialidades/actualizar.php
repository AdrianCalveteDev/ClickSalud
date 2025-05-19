<?php
    
    use App\Especialidad;
    use Intervention\Image\Drivers\Gd\Driver;
    // Libreria de intervetion/image cargada desde composer para la subida de archivos.
    use Intervention\Image\ImageManager as Image;

    // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos
    require '../../../includes/app.php';

    autenticar();
    
    // Variable con el ID del servicio, donde nos aseguramos de que solo pueda ser un dato de tipo integer
    // Esto evita que alguien intente pasar un dato no valido, evita SQL injection y XSS
    $idEspecialidad = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Si se pasa un dato que no es un INT, redirigimos al usuario al panel de administración de los servicios.
    if (!$idEspecialidad){
        header('Location: /admin/propiedades/especialidades/index.php');
    }

    // Obtenemos los datos del servicio
    $especialidad = Especialidad::buscar($idEspecialidad);

    // Consulta para obtener las especialidades desde base de datos
    $especialidades = Especialidad::all();

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
            <?php include '../../../includes/templates/formulario_especialidades.php' ?> 

            <input type="submit" value="Actualizar servicio" class="boton-verde">
        </form>

    </main>

<?php
    include '../../../includes/templates/footer.php';
?>