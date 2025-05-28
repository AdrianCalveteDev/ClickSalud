<main class="contenedor">
        <h1>Servicios de ClickSalud</h1>
            <?php
                if ($resultado){
                    $mensaje = mostrarMensaje(intval($resultado), 'Servicio');
                    if ($mensaje) { ?>
                    <p class="creado"><?php echo s($mensaje) ?></p>
                    <?php }
                }
            ?>
        <a href="/admin" class="boton-verde">Volver</a>
        <a href="/servicios/crear" class="boton-verde">Crear</a>

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
                            <form method="POST" action="/servicios/eliminar">
                                <!-- Input auxiliar oculto para recoger el ID del servicio a eliminar -->
                                <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">

                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a class="boton-amarillo-block" href="actualizar?id=<?php echo $servicio->id;?>">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</main>