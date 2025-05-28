<main class="contenedor">
        <h1>Iniciar sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario contenido-centrado" method="POST" action="/login">
            <fieldset>
                <legend>Acceso a ClickSalud</legend>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email..." require>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena_hash" id="contrasena" placeholder="Tu contraseña..." require>
            </fieldset>

            <input type="submit" value="Iniciar sesión" class="boton-verde">

        </form>
    </main>

    <section class="servicio-login">
        <div class="contenedor-servicio-login">
            <h2>¿Aún no tienes una cuenta?</h2>
            <p>Crea tu cuenta de manera gratuita y comienza a disfrutar de las ventajas que te ofrece Click Salud</p>
            <a class="boton-verde" href="/crearUsuario">crear cuenta</a>
        </div>
    </section>