<main class="contenedor">
    <h1>Crear cuenta en ClickSalud</h1>

    <?php foreach($errores as $error): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario contenido-centrado" method="POST" action="/crearUsuario">
        <fieldset>
            <legend>Nuevo Usuario</legend>

            <label for="nombre">Nombre</label>
            <input type="nombre" name="nombre" id="nombre" placeholder="Tu nombre..." require>

            <label for="apellido">Apellido</label>
            <input type="apellido" name="apellido" id="apellido" placeholder="Tu apellido..." require>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu email..." require>

            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena_hash" id="contrasena" placeholder="Tu contraseña..." require>

            <label for="repetir_contrasena">Repetir Contraseña</label>
            <input type="password" name="repetir_contrasena" id="repetir_contrasena" placeholder="Repite tu contraseña..." required>

        </fieldset>

        <input type="submit" value="Crear cuenta" class="boton-verde">

    </form>
</main>