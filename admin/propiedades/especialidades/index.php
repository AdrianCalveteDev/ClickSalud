<?php

    // Importar la conexión
    require '../../../includes/app.php';
    autenticar();

    use App\Especialidad;
    use App\Servicio;

    // Implementamos metodo para obtener las especialidades y los servicios
    $servicios = Servicio::all();
    $especialidades = Especialidad::all();

    // Muestra mensaje según la acción que suceda
    $resultado = $_GET['resultado'] ?? null;


    // Cuando se envíe el formulario de eliminar, asignamos a la variable el ID del servicio
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idEspecialidad = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if($idEspecialidad){
            // Obtenemos los datos del especialidad
            $especialidad = Especialidad::buscar($idEspecialidad);
            // Eliminamos la especialidad
            $especialidad->eliminar(MENSAJES_ESPECIALIDADES);        
        }   
    }

    // Incluir el template con todo el diseño del header
    include '../../../includes/templates/header.php';
    
?>

    <main class="contenedor">
        <h1>Especialidades de ClickSalud</h1>
            <?php if(intval($resultado) === 1): ?>
                <p class="creado">Especialidad creada correctamente</p>
            <?php elseif(intval($resultado) ===2): ?>
                <p class="creado">Especialidad actualizada correctamente</p>
            <?php elseif(intval($resultado) ===3): ?>
                <p class="creado">Especialidad eliminada correctamente</p>        
            <?php endif ?>    
        <a href="/admin/index.php" class="boton-verde">Volver</a>
        <a href="/admin/propiedades/especialidades/crear.php" class="boton-verde">Crear</a>

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
                            <form method="POST">
                                <!-- Input auxiliar oculto para recoger el ID del servicio a eliminar -->
                                <input type="hidden" name="id" value="<?php echo $especialidad->id; ?>">
                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a class="boton-amarillo-block" href="actualizar.php?id=<?php echo $especialidad->id;?>">Actualizar</a>
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