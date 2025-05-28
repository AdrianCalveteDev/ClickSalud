<main class="contenedor">
        <h1>Especialidades de ClickSalud</h1>
            <?php if(intval($resultado) === 1): ?>
                <p class="creado">Especialidad creada correctamente</p>
            <?php elseif(intval($resultado) ===2): ?>
                <p class="creado">Especialidad actualizada correctamente</p>
            <?php elseif(intval($resultado) ===3): ?>
                <p class="creado">Especialidad eliminada correctamente</p>        
            <?php endif ?>    
        <a href="/admin" class="boton-verde">Volver</a>
        <a href="/especialidades/crear" class="boton-verde">Crear</a>

        <table class="servicios-lista">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Logo</th>
                    <th>Imágen</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados de la base de datos -->
                <?php foreach( $especialidades as $especialidad ): ?>
                    <tr>
                        <td><?php echo $especialidad->id;?></td>
                        <td><?php echo $especialidad->nombre;?></td>
                        <td><img src="/imagenes/especialidades/<?php echo $especialidad->logo;?>" class="servicios-lista_imagen" alt=""></td>
                        <td><img src="/imagenes/especialidades/<?php echo $especialidad->imagen;?>" class="servicios-lista_imagen" alt=""></td>
                        <td><?php echo $especialidad->descripcion;?></td>
                        <td>
                        <!-- GENERAMOS UN FORMULARIO PARA DARLE LA POSIBILIDAD AL USUARIO DE ELIMINAR EL REGISTRO -->
                            <form method="POST" action="/especialidades/eliminar">
                                <!-- Input auxiliar oculto para recoger el ID del servicio a eliminar -->
                                <input type="hidden" name="id" value="<?php echo $especialidad->id; ?>">
                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a class="boton-amarillo-block" href="actualizar?id=<?php echo $especialidad->id;?>">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>