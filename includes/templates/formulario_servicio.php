<fieldset>
    <legend>Información general del servicio</legend>

    <label for="especialidad">Especialidad</label>
    <select name="servicio[especialidad_id]" id="especialidad">
        <option value="" default>-- Seleccione --</option>
        <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de active record, que devuelve un objeto 
        que recorremos con un foreach donde podemos ir recogiendo los valores del objeto apuntando con sintaxis de flecha a la 
        propiedad correspondiente -->
        <?php foreach($especialidades as $especialidad) {?>
            <!-- Validamos en el ternario que tenga un valor por si saltan las validaciones mantener el dato que había seleccionado
             el usuario -->
            <option
                <?php echo $servicio->especialidad_id === $especialidad->id ? 'selected' : ''; ?> 
                value="<?php echo s($especialidad->id); ?>"><?php echo s($especialidad->nombre) ?>
            </option>
        <?php } ?>    
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