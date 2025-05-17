<?php

    // Importar la conexión
    require '../../../includes/app.php';
    autenticar();

    use App\Servicio;

    // Implementamos metodo para obtener los servicios
    $servicios = Servicio::all();

    // Muestra mensaje según la acción que suceda
    $resultado = $_GET['resultado'] ?? null;


    // Cuando se envíe el formulario de eliminar, asignamos a la variable el ID del servicio
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idServicio = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if($idServicio){

            // Obtenemos los datos del servicio
            $servicio = Servicio::buscarServicio($idServicio);

            $servicio->eliminarServicio();        
            
        }   
    }

    // Incluir el template con todo el diseño del header
    include '../../../includes/templates/header.php';
    
?>

    <main class="contenedor">
        <h1>Servicios de ClickSalud</h1>
            <?php if(intval($resultado) === 1): ?>
                <p class="creado">Servicio creado correctamente</p>
            <?php elseif(intval($resultado) ===2): ?>
                <p class="creado">Servicio actualizado correctamente</p>
            <?php elseif(intval($resultado) ===3): ?>
                <p class="creado">Servicio eliminado correctamente</p>        
            <?php endif ?>    
        <a href="/admin/index.php" class="boton-verde">Volver</a>
        <a href="/admin/propiedades/servicios/crear.php" class="boton-verde">Crear</a>

        <table class="servicios-lista">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imágen</th>
                    <th>Precio</th>
                    <th>Duración (min)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados de la base de datos -->
                <?php foreach( $servicios as $servicio ): ?>
                    <tr>
                        <td><?php echo $servicio->id;?></td>
                        <td><?php echo $servicio->nombre;?></td>
                        <td><img src="/imagenes/servicios/<?php echo $servicio->imagen;?>" class="servicios-lista_imagen" alt=""></td>
                        <td><?php echo $servicio->precio;?>€</td>
                        <td><?php echo $servicio->duracion_min;?>min.</td>
                        <td>
                        <!-- GENERAMOS UN FORMULARIO PARA DARLE LA POSIBILIDAD AL USUARIO DE ELIMINAR EL REGISTRO -->
                            <form method="POST">
                                <!-- Input auxiliar oculto para recoger el ID del servicio a eliminar -->
                                <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">

                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a class="boton-amarillo-block" href="actualizar.php?id=<?php echo $servicio->id;?>">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php

    // Cerramos la conexión de la base de datos
    mysqli_close($baseDatos);

    // Importamos el diseño del footer
    include '../../../includes/templates/footer.php';
?>