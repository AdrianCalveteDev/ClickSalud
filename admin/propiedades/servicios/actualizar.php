<?php

    // Variable con el ID del servicio, donde nos aseguramos de que solo pueda ser un dato de tipo integer
    // Esto evita que alguien intente pasar un dato no valido, evita SQL injection y XSS
    $idServicio = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Si se pasa un dato que no es un INT, redirigimos al usuario al panel de administración de los servicios.
    if (!$idServicio){
        header('Location: /admin/propiedades/servicios/index.php');
    }

    // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos
    require '../../../includes/config/database.php';
    $baseDatos = conectarBD(); // Función para conectar la base de datos

    // Consulta para obtener los datos del servicio y mostrarselos por defecto al usuario en el formulario
    $queryServicio = "SELECT * FROM servicios WHERE id = $idServicio";
    $resultadoServicio = mysqli_query($baseDatos, $queryServicio);
    // Construimos un array asociativo con los resultados de la query
    $servicio = mysqli_fetch_assoc($resultadoServicio);

    // Consulta para obtener las especialidades desde base de datos
    $consulta = "SELECT * FROM especialidades";
    $resultadoEspecialidad = mysqli_query($baseDatos, $consulta);

    // Array para almacenar los errores
    $errores = [];

    // Como estamos actualizando y debemos mostrarle al usuario los datos que ya existen para una mejor UX, le asignamos 
    // los valores del servicio con la información de la base de datos.
    $especialidad_id = $servicio['especialidad_id'];
    $nombre = $servicio['nombre'];
    $descripcion = $servicio['descripcion'];
    $imagen = $servicio['imagen'];
    $precio = $servicio['precio'];
    $duracion = $servicio['duracion_min'];

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
        // Rellenar campo de auditoría para saber cuando se ha actualizado el registro
        $actualizado_en = date('Y-m-d H:i:s');

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
        
        // Validar el tamaño de la imágen, para que el usuario no nos llene el servidor de archivos muy pesados
        $tamanioMax = 1000 * 1000; // bytes a kilobytes = 1Mb
        if ($imagen['size'] > $tamanioMax){
            $errores[] = "El peso de la imágen debe ser inferior";
        }

        // Miramos que el arreglo de los errores esté vacío con el método empty de PHP y si está vacío ejecutamos la query contra la BBDD
        if(empty($errores)){

            /* Para la subida de imágenes */

            // Creamos la carpeta donde se almacenarás las diferente imágenes
            $carpetaImg = '../../../imagenes';
            // Creamos la ruta donde se almacenarán las imágenes solo de los servicios
            $carpetaImgServicios = '../../../imagenes/servicios/';

            // Si la carpeta principal no existe, la creamos
            if(!is_dir($carpetaImg)){
                mkdir($carpetaImg);
            }
            // Si la carpeta para almacenar las imagenes de servicios no existe, la creamos
            if(!is_dir($carpetaImgServicios)){
                mkdir($carpetaImgServicios);
            }

            $nombreImagenServicio = '';

            // Nos aseguramos de que haya una imagen ya existente, para eliminarla y no saturar el servidor con imagenes innecesarias
            // Si ya existe una imagen...
            if ($imagen['name']){
                unlink($carpetaImgServicios . $servicio['imagen']); //la eliminamos para actualizarla por la nueva

                // A la imágen que va a subir nuestro usuario le debemos asignar un nombre único para que no coincida nunca con otras
                // imágenes que pueden subir otros usuarios. Lo hacemos generando un número unico, randomizado y hasheado (md5)
                $nombreImagenServicio = md5(uniqid(rand(), true)) . ".jpg";

                // Subimos la imagen a la carpeta con el método move_upload_file
                // Como primer parametro le ponemos el nombre temporal del fichero y como segundo parámetro el nombre que le daremos
                move_uploaded_file($imagen['tmp_name'], $carpetaImgServicios . $nombreImagenServicio);
            } else {
                $nombreImagenServicio = $servicio['imagen'];
            }

                      

            // Actualizar los datos en la base de datos
            $query = "UPDATE servicios SET 
                        nombre = '$nombre',
                        descripcion = '$descripcion', 
                        precio = '$precio',
                        duracion_min = '$duracion',
                        especialidad_id = '$especialidad_id',
                        actualizado_en = '$actualizado_en',
                        imagen = '$nombreImagenServicio'
                      WHERE id = $idServicio;
                     ";

            $resultado = mysqli_query($baseDatos, $query);


            if($resultado){
                //Si el formulario funciona correctamente, redirigimos al usuario a la página del administrador
                // pasandole la variable resultado=2 para mostrar mensaje de actualización al usuario
                header('Location: /admin/propiedades/servicios/index.php?resultado=2');
            } else {
                // Mostrar el error
                echo "Error en la consulta: " . mysqli_error($baseDatos);
            }
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

                <img class="imagen-actualizar" src="/imagenes/servicios/<?php echo $imagen; ?>" alt="">

                <label for="precio">Precio:</label>
                <input name="precio" type="number" id="precio" placeholder="Precio del servicio" value="<?php echo $precio;?>">

                <label for="duracion">Duración (min):</label>
                <input name="duracion" type="number" id="duracion" placeholder="Duración en minutos" min="30" max="120" value="<?php echo $duracion;?>">

            </fieldset>

            <input type="submit" value="Actualizar servicio" class="boton-verde">
        </form>

    </main>

<?php
    include '../../../includes/templates/footer.php';
?>