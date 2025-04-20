<?php
    include '../includes/templates/header.php';
?>

    <main class="contenedor">
        <h1>Contacto</h1>

        <form class="formulario" action="">
            <fieldset>
                <legend>Información personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre...">

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" placeholder="Tu apellido...">

                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Tu correo...">

                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" placeholder="Tu teléfono...">

            </fieldset>
            <fieldset>
                <legend>Contacto</legend>

                <p>Elige la especialidad sobre la que deseas Información</p>
                <select name="especialidades" id="especialidades">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="odontologia">Odontología</option>
                    <option value="estetica">Estética</option>
                </select>

                <p>Elige como quieres ser contactado</p>
                <div class="forma-contacto">
                    <label for="contacto-tel">Teléfono</label>
                    <input name="contacto" type="radio" value="telefono" id="contacto-tel">

                    <label for="contacto-mail">E-mail</label>
                    <input name="contacto" type="radio" value="email" id="contacto-mail">
                </div>

                <p>Si eligió teléfono elija la fecha y la hora para ser contactado</p>
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">

                <label for="hora">Hora</label>
                <input type="time" id="hora" min="09:00" max="20:00">

                <label for="mensaje">Mensaje</label>
                <textarea name="mensaje" id="mensaje"></textarea>

            </fieldset>

            <input type="submit" value="enviar" class="boton-verde">

        </form>
    </main>

<?php
    include '../includes/templates/footer.php';
?>