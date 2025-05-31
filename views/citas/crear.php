<main class="contenedor">
    <h1>Reservar Cita</h1>

    <?php foreach($errores as $error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">

        <a href="/citas/misCitas" class="boton-verde">Volver</a>
        <br>

        <label for="especialidad">Especialidad</label>
        <select name="cita[especialidad_id]" id="especialidad">
            <option value="" default>-- Seleccione --</option>
            <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de active record, que devuelve un objeto 
            que recorremos con un foreach donde podemos ir recogiendo los valores del objeto apuntando con sintaxis de flecha a la 
            propiedad correspondiente -->
            <?php foreach($especialidades as $especialidad) {?>
                <!-- Validamos en el ternario que tenga un valor por si saltan las validaciones mantener el dato que había seleccionado
                el usuario -->
                <option
                    <?php echo $cita->especialidad_id === $especialidad->id ? 'selected' : ''; ?> 
                    value="<?php echo s($especialidad->id); ?>"><?php echo s($especialidad->nombre) ?>
                </option>
            <?php } ?>    
        </select>

        <label for="especialidad">Centro médico</label>
        <select name="cita[centro_id]" id="centro">
            <option value="" default>-- Seleccione --</option>
            <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de active record, que devuelve un objeto 
            que recorremos con un foreach donde podemos ir recogiendo los valores del objeto apuntando con sintaxis de flecha a la 
            propiedad correspondiente -->
            <?php foreach($centros as $centro) {?>
                <!-- Validamos en el ternario que tenga un valor por si saltan las validaciones mantener el dato que había seleccionado
                el usuario -->
                <option
                    <?php echo $cita->centro_id === $centro->id ? 'selected' : ''; ?> 
                    value="<?php echo s($centro->id); ?>"><?php echo s($centro->nombre) ?>
                </option>
            <?php } ?>    
        </select>

        <label for="servicio">Elige tu servicio</label>
        <select name="cita[servicio_id]" id="servicio" disabled>
            <option value="" default>-- Seleccione una especialidad primero --</option>
            <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de active record, que devuelve un objeto 
            que recorremos con un foreach donde podemos ir recogiendo los valores del objeto apuntando con sintaxis de flecha a la 
            propiedad correspondiente -->
            <?php foreach($servicios as $servicio) {?>
                <!-- Validamos en el ternario que tenga un valor por si saltan las validaciones mantener el dato que había seleccionado
                el usuario -->
                <option
                    <?php echo $cita->servicio_id === $servicio->id ? 'selected' : ''; ?> 
                    value="<?php echo s($servicio->id); ?>"><?php echo s($servicio->nombre) ?>
                </option>
            <?php } ?>    
        </select>

        <label for="especialista">Selecciona tu especialista</label>
        <select name="cita[especialista_id]" id="especialista" disabled>
            <option value="" default>-- Seleccione especialidad y centro primero --</option>
            <!-- Cargamos en las diferentes especialidades desde base de datos haciendo uso de active record, que devuelve un objeto 
            que recorremos con un foreach donde podemos ir recogiendo los valores del objeto apuntando con sintaxis de flecha a la 
            propiedad correspondiente -->

            <?php foreach($especialistas as $especialista) {?>
                <!-- Validamos en el ternario que tenga un valor por si saltan las validaciones mantener el dato que había seleccionado
                el usuario -->
                <option
                    <?php echo $cita->especialista_id === $especialista->id ? 'selected' : ''; ?> 
                    value="<?php echo s($especialista->id); ?>"><?php echo s($especialista->nombre) . " " . s($especialista->apellido) ?>
                </option>
            <?php } ?>    
        </select>

        <label for="fecha">Fecha</label>
        <input type="date" name="cita[fecha_cita]" id="fecha" required>

        <label for="hora">Hora</label>
        <input type="time" name="cita[hora_cita]" id="hora" required>

        <input type="submit" value="Reservar Cita" class="boton-verde">
    </form>
</main>
