<main class="contenedor">
        <h1>Contacto</h1>

        <?php
            if($mensaje){
                if($exito){
                    echo "<p class='creado'>" . $mensaje . "</p>";
                } else {
                    echo "<p class='error'>" . $mensaje . "</p>";
                } 
            }
        ?>

        <form class="formulario" action="/contacto" method="POST">
            <fieldset>
                <legend>Información personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre..." name="contacto[nombre]" required>

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" placeholder="Tu apellido..." name="contacto[apellido]" required>

            </fieldset>
            <fieldset>
                <legend>Contacto</legend>

                <p>Elige la especialidad sobre la que deseas Información</p>
                <select name="contacto[especialidad]" id="especialidades" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="odontologia">Odontología</option>
                    <option value="estetica">Estética</option>
                </select>

                <p>Elige como quieres ser contactado</p>
                <div class="forma-contacto">
                    <label for="contacto-tel">Teléfono</label>
                    <input name="contacto[contacto]" type="radio" value="telefono" id="contacto-tel" required>

                    <label for="contacto-mail">E-mail</label>
                    <input name="contacto[contacto]" type="radio" value="email" id="contacto-mail">
                </div>

                <br>
                <div id="contacto"></div>

                <label for="mensaje">Mensaje</label>
                <textarea name="contacto[mensaje]" id="mensaje" required></textarea>

            </fieldset>

            <input type="submit" value="enviar" class="boton-verde">

        </form>
    </main>