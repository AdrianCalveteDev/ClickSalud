<?php
    // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos
    require '../../includes/config/database.php';
    $baseDatos = conectarBD(); // Función para conectar la base de datos

    // Consulta para obtener las especialidades desde base de datos
    $consulta = "SELECT * FROM especialidades";
    $resultadoEspecialidad = mysqli_query($baseDatos, $consulta);

    // Array para almacenar los errores
    $errores = [];

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
        // Asignamos a las variables el contenido que llega desde el formulario
        // Con mysqli_real_escape_string sanitizamos la entrada a bbdd y evitamos sql injection y XSS
        $especialidad_id = mysqli_real_escape_string($baseDatos, $_POST['especialidad']);
        $nombre = mysqli_real_escape_string($baseDatos, $_POST['nombre']);
        $descripcion = mysqli_real_escape_string($baseDatos, $_POST['descripcion']);
        // Asociar archivos a una variable
        $imagen = $_FILES['imagen'];
        $precio = mysqli_real_escape_string($baseDatos, $_POST['precio']);
        $duracion = mysqli_real_escape_string($baseDatos, $_POST['duracion']);
        // Rellenar campo de auditoría para saber cuando se ha creado el registro
        $creado_en = date('Y-m-d H:i:s');

        /* VALIDAMOS LOS DATOS DEL FORMULARIO */
        // Si no se selecciona una especialidad, llenamos el array con el error.
        if(!$especialidad_id){
            $errores[] = "Es necesario seleccionar una especialidad";
        }

        // Si el nombre no se rellena, llenamos el array de errores con el error correspondiente.
        if(!$nombre) {
            $errores[] = "El nombre es obligatorio";
        }
        // Si no se pone un precio, le indicamos al usuario mediante mensaje de error que es obligatio.
        if(!$precio){
            $errores[] = "El precio es obligatorio";
        }
        // De la misma manera, indicamos al usuario que debe definir la duración del servicio.
        if(!$duracion){
            $errores[] = "Debes definir la duración del servicio en minutos";
        }
        // Como la imagen la extraemos con la superglobal $_FILE, se nos genera un array asociativo mediante el cual podemos verificar diferentes
        // propiedades, entre ellas el nombre, podemos validar que si no tiene un nombre le lanzaremos error al usuario.
        if(!$imagen['name'] || $imagen['error']){
            $errores[] = "La imágen es obligatoria";
        }
        // Validar el tamaño de la imágen, para que el usuario no nos llene el servidor de archivos muy pesados
        $tamanioMax = 1000 * 400; // bytes a kilobytes = 400kb
        if ($imagen['size'] > $tamanioMax){
            $errores[] = "El peso de la imágen debe ser inferior";
        }

        // Miramos que el arreglo de los errores esté vacío con el método empty de PHP y si está vacío ejecutamos la query contra la BBDD
        if(empty($errores)){

            /* Para la subida de imágenes */
            // Creamos la ruta donde se almacenarán los datos
            $carpetaImgServicios = '../../imagenes/servicios';

            // Si la carpeta no existe, la creamos
            if(!is_dir($carpetaImgServicios)){
                mkdir($carpetaImgServicios);
            }
            

            // Insertar los datos en la base de datos
            $query = "INSERT INTO servicios (nombre, descripcion, precio, duracion_min, especialidad_id, imagen, creado_en)
            VALUES ('$nombre', '$descripcion', '$precio', '$duracion', '$especialidad_id', '$imagen', '$creado_en');
            ";

            $resultado = mysqli_query($baseDatos, $query);

            if($resultado){
                //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
                header('Location: /admin');
            }
        }
        
    }

    include '../../includes/templates/header.php';
?>

    <main class="formulario">
        <h1>Crear nuevo servicio</h1>

        <a href="/admin/index.php" class="boton-verde">Volver</a>

        <!-- Fragmento de código PHP para mostrar los errores que contenga el array, si es que tuviese alguno -->
        <?php foreach($errores as $error): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>    

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data"> <!-- enctype nos permite leer mejor el contenido de los archivos que se envíen desde el formulario --> 
            <fieldset>
                <legend>Información general del servicio</legend>

                <label for="especialidad">Especialidad</label>
                <select name="especialidad" id="especialidad">
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
                <input name="duracion" type="number" id="duracion" placeholder="Duración en minutos" min="30" max="120" value="<?php echo $duracion;?>">

            </fieldset>

            <input type="submit" value="Crear servicio" class="boton-verde">
        </form>

    </main>

<?php
    include '../../includes/templates/footer.php';
?>