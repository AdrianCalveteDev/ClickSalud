<fieldset>
    <legend>Información general del servicio</legend>

    <label for="especialidad">Especialidad</label>
    <select name="servicio[especialidad_id]" id="especialidad">
        <option value="" default>-- Seleccione --</option>
        <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de fetch_assoc, que devuelve un array 
        asociativo donde podemos ir recogiendo los valores con el nombre de las columnas de la tabla -->
        <?php while($especialidad = mysqli_fetch_assoc($resultadoEspecialidad)): ?>
        <!-- Operador ternario para evaluar si el id ya está asignado o no, pare realizar la persistencia del dato -->
        <option <?php echo s($servicio->especialidad_id) === $especialidad['id'] ? 'selected': '' ?> value="1"><?php echo $especialidad['nombre']?></option>
        <?php endwhile ?>
    </select>

    <label for="nombre">Nombre:</label>
    <input name="servicio[nombre]" type="text" placeholder="Nombre del servicio" value="<?php echo s($servicio->nombre); ?>">

    <label for="descripcion">Descripción:</label>
    <textarea name="servicio[descripcion]" id="descripcion" placeholder="Descripción del servicio"><?php echo s($servicio->descripcion);?></textarea>

    <label for="imagen">Imágen</label>
    <input name="servicio[imagen]" type="file" id="imagen" accept="image/png, image/jpeg">

    <?php if($servicio->imagen){ ?>
        <img src="/imagenes/servicios/<?php echo $servicio->imagen ?>" class="servicio-imagen" alt="Imágen del servicio">
    <?php } ?>    

    <label for="precio">Precio:</label>
    <input name="servicio[precio]" type="number" id="precio" placeholder="Precio del servicio" value="<?php echo s($servicio->precio);?>">

    <label for="duracion">Duración (min):</label>
    <input name="servicio[duracion_min]" type="number" id="duracion" placeholder="Duración en minutos" min="30" max="120" value="<?php echo s($servicio->duracion_min);?>">

</fieldset>