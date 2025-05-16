<?php

    // Importar conexiones de la base de datos.
    require '../includes/app.php';
    $baseDatos = conectarBD();

    // Autenticar el usuario

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Asignamos la variable de email validando que cumpla el formato de email
        $email = mysqli_real_escape_string($baseDatos, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $contrasena = mysqli_real_escape_string($baseDatos, $_POST['contrasena']);

        

        if (!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }

        if(!$contrasena){
            $errores[] = "La contraseña es obligatoria";
        }

        if(empty($errores)){
            // Comprobar que el usuario existe en la base de datos
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($baseDatos, $query);
            
            // En caso que el numero de filas tenga contenido, es que el usuario existe en la base de datos
            if ($resultado->num_rows){
                // Si el usuario existe, comprobamos que la contraseña del usuario sea correcta
                $usuario = mysqli_fetch_assoc($resultado);

                // Revisamos que la contraseña sea correcta o no
                $autenticado = password_verify($contrasena, $usuario['contrasena_hash']);

                if ($autenticado){
                    // El usuario está autenticado y generamos la superglobal sesión con la función session_star()
                    session_start();

                    // Construimos el array de sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    $_SESSION['rol'] = $usuario['rol'];
                    
                    // Si el usuario es rol admin, le llevamos al panel de administración
                    if ($_SESSION['rol']==='admin'){
                        header('Location: /admin');
                    }
                    
                } else {
                    $errores[] = "La contraseña es incorrecta";
                }

            } else {
                // Si no encontramos al usuario en la base de datos, notificamos al usuario que ese correo no existe.
                $errores[] = "El usuario no existe";
            }
        }
    }

    // Incluir el header
    include '../includes/templates/header.php';
?>

    <main class="contenedor">
        <h1>Iniciar sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario contenido-centrado" method="POST" action="">
            <fieldset>
                <legend>Acceso a ClickSalud</legend>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Tu email..." require>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Tu contraseña..." require>
            </fieldset>

            <input type="submit" value="Iniciar sesión" class="boton-verde">

        </form>
    </main>

    <section class="servicio-login">
        <div class="contenedor-servicio-login">
            <h2>¿Aún no tienes una cuenta?</h2>
            <p>Crea tu cuenta de manera gratuita y comienza a disfrutar de las ventajas que te ofrece Click Salud</p>
            <a class="boton-verde" href="#">crear cuenta</a>
        </div>
    </section>

<?php
    include '../includes/templates/footer.php';
?>