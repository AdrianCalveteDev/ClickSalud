<?php

    // Importar la conexión
    require '../../../includes/app.php';
    autenticar();

    use App\Especialidad;
    use App\Servicio;

    // Implementamos metodo para obtener los servicios
    $servicios = Servicio::all();
    $especialidades = Especialidad::all();

    // Muestra mensaje según la acción que suceda
    $resultado = $_GET['resultado'] ?? null;


    // Cuando se envíe el formulario de eliminar, asignamos a la variable el ID del servicio
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idServicio = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if($idServicio){

            // Obtenemos los datos del servicio
            $servicio = Servicio::buscar($idServicio);

            $servicio->eliminar(MENSAJES_SERVICIOS);        
            
        }   
    }

    // Incluir el template con todo el diseño del header
    include '../../../includes/templates/header.php';
    
?>

    <main class="contenedor">
        <h1>Servicios de ClickSalud</h1>
            <?php 
                $mensaje = mostrarMensaje(intval($resultado), 'Servicio');
                if ($mensaje) { ?>
                    <p class="creado"><?php echo s($mensaje) ?></p>
            <?php } ?>    
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
    // Importamos el diseño del footer
    include '../../../includes/templates/footer.php';
?>