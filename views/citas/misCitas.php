<main class="contenedor">
    <h1>Mis Citas</h1>

    <p>Hola <?php echo $usuario->nombre . " " . $usuario->apellido?></p>

    <?php if(intval($resultado) === 1): ?>
        <p class="creado">Cita creada correctamente</p>
    <?php elseif(intval($resultado) ===3): ?>
        <p class="creado">Cita eliminada correctamente</p>        
    <?php endif ?>  
    
    <a href="/citas/crear" class="boton-verde">+ Nueva Cita</a>

    <?php if (empty($citas)): ?>
        <p>No tienes citas programadas.</p>
    <?php else: ?>
 
        <table class="servicios-lista">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Especialidad</th>
                    <th>Servicio</th>
                    <th>Doctor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?php echo $cita->fecha_cita; ?></td>
                        <td><?php echo $cita->hora_cita; ?></td>
                        <td>
                            <?php 
                                $nombreEspecialidad = $especialidades[$cita->especialidad_id] ?? 'Desconocida';
                                echo ucfirst($nombreEspecialidad);
                            ?>
                        </td>
                        <td>
                            <?php 
                                $nombreServicio = $servicios[$cita->servicio_id] ?? 'Desconocido';
                                echo ucfirst($nombreServicio);
                            ?>
                        </td>
                        <td>
                            <?php 
                                $nombreEspecialista = $especialistas[$cita->especialista_id] ?? 'Desconocido';
                                echo ucfirst($nombreEspecialista);
                            ?>
                        </td>
                        <td>
                            <form method="POST" action="/citas/eliminar">
                                <!-- Input auxiliar oculto para recoger el ID del servicio a eliminar -->
                                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                                <input type="submit" value="Cancelar cita" class="boton-rojo-block">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>
