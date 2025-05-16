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

    // Consulta para obtener las especialidades desde base de datos
    $consulta = "SELECT * FROM especialidades";
    $resultadoEspecialidad = mysqli_query($baseDatos, $consulta);

    // Array para almacenar los errores desde el metodo estático de la clase
    $errores = Servicio::getErrores();

    // Asignamos las variables vacías (en el formulario aprovecharemos la variable para la persistencia del dato en caso de que el formulario)
    // no se pueda enviar a causa de alguno de los errores de validación.
    $especialidad_id = '';
    $nombre = '';
    $descripcion = '';
    $imagen = '';
    $precio = '';
    $duracion = '';

    // Comprobamos si el metodo de envío del formulario es de tipo POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Creamos una instancia de nuestra clase Servicio
        $servicio = new Servicio($_POST);

        // A la imágen que va a subir nuestro usuario le debemos asignar un nombre único para que no coincida nunca con otras
        // imágenes que pueden subir otros usuarios. Lo hacemos generando un número unico, randomizado y hasheado (md5)
        $nombreImagenServicio = md5(uniqid(rand(), true)) . ".jpg";
        if($_FILES['imagen']['tmp_name']){
            $manager = new Image(Driver::class);
            $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
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

            $resultado = $servicio->crearRegistro();
            if($resultado){
                //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
                header('Location: /admin/propiedades/servicios/index.php?resultado=1');
            }
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
            <fieldset>
                <legend>Información general del servicio</legend>

                <label for="especialidad">Especialidad</label>
                <select name="especialidad_id" id="especialidad">
                    <option value="" default>-- Seleccione --</option>
                    <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de fetch_assoc, que devuelve un array 
                    asociativo donde podemos ir recogiendo los valores con el nombre de las columnas de la tabla -->
                    <?php while($especialidad = mysqli_fetch_assoc($resultadoEspecialidad)): ?>
                        <!-- Operador ternario para evaluar si el id ya está asignado o no, pare realizar la persistencia del dato -->
                        <option <?php echo $especialidad_id === $especialidad['id'] ? 'selected': '' ?> value="<?php echo $especialidad['id'] ?>"><?php echo $especialidad['nombre']?></option>
                    <?php endwhile ?>
                </select>

                <label for="nombre">Nombre:</label>
                <input name="nombre" type="text" placeholder="Nombre del servicio" value="<?php echo $nombre; ?>">

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción del servicio"><?php echo $descripcion;?></textarea>

                <label for="imagen">Imágen</label>
                <input name="imagen" type="file" id="imagen" accept="image/png, image/jpeg">

                <label for="precio">Precio:</label>
                <input name="precio" type="number" id="precio" placeholder="Precio del servicio" value="<?php echo $precio;?>">

                <label for="duracion">Duración (min):</label>
                <input name="duracion_min" type="number" id="duracion" placeholder="Duración en minutos" min="30" max="120" value="<?php echo $duracion;?>">

            </fieldset>

            <input type="submit" value="Crear servicio" class="boton-verde">
        </form>

    </main>

<?php
    include '../../../includes/templates/footer.php';
?>