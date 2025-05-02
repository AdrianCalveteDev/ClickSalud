<?php

    // Importar la conexión
    require '../../../includes/config/database.php';
    $baseDatos = conectarBD();

    // Query de la base de datos
    $query = "SELECT * FROM servicios";

    // Consulta a la base de datos
    $resultadoQuery = mysqli_query($baseDatos, $query);

    // Muestra mensaje según la acción que suceda
    $resultado = $_GET['resultado'] ?? null;

    // Incluir el template con todo el diseño del header
    include '../../../includes/templates/header.php';
    
?>

    <main class="contenedor">
        <h1>Servicios de ClickSalud</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="creado">Servicio creado correctamente</p>
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
                <!-- Mientras que la variable de servicios encuentre un resultado en la query, lo convertimos en un array asociativo
                para poder ir iterando sobre sus propiedades (nombre de las columnas)  -->
                <?php while($servicio = mysqli_fetch_assoc($resultadoQuery)): ?>
                    <tr>
                        <td><?php echo $servicio['id'];?></td>
                        <td><?php echo $servicio['nombre'];?></td>
                        <td><img src="/imagenes/servicios/<?php echo $servicio['imagen'];?>" class="servicios-lista_imagen" alt=""></td>
                        <td><?php echo $servicio['precio'];?>€</td>
                        <td><?php echo $servicio['duracion_min'];?>min.</td>
                        <td>
                            <a class="boton-rojo-block" href="#">Eliminar</a>
                            <a class="boton-amarillo-block" href="#">Actualizar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php

    // Cerramos la conexión de la base de datos
    mysqli_close($baseDatos);

    // Importamos el diseño del footer
    include '../../../includes/templates/footer.php';
?>