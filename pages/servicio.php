<?php
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Si el id recibido no es un int o está vacío redirigimos al usuario a la home
    if(!$id){
        header('Location: /');
    }

    // Importar base de datos
    require '../includes/app.php';
    $baseDatos = conectarBD();
    // Consultar especialidades
    $queryEspecialidad = "SELECT * FROM especialidades WHERE id = $id";

    // Obtener resultado
    $resultado = mysqli_query($baseDatos, $queryEspecialidad);

    // Si el id recibido no tiene ningún resultado en la base de datos redirigimos al usuario a la home
    if (!$resultado->num_rows){
        header('Location: /');
    }

    $especialidad = mysqli_fetch_assoc($resultado);

    include '../includes/templates/header.php';
?>

    <main class="contenedor">
        <h1><?php echo $especialidad['nombre']; ?></h1>

        <img class="servicio-imagen" src="../build/img/<?php echo $especialidad['imagen']; ?>" alt="Imagen de la especialidad">

        <div class="servicio-texto">
            <p><?php echo $especialidad['descripcion_larga']; ?></p>
            <p><?php echo $especialidad['descripcion_larga_2']; ?></p>
        </div>
    </main>

    <section class="servicio-login">
        <div class="contenedor-servicio-login">
            <h2>¿Listo para reservar tus citas?</h2>
            <p>Empieza a usar nuestra aplicación hoy mismo y gestiona tus citas médicas con comodidad.</p>
            <a class="boton-verde" href="login.php">Iniciar sesión o crear cuenta</a>
        </div>
    </section>

<?php
    // Cerramos la conexión con la base de datos
    mysqli_close($baseDatos);

    include '../includes/templates/footer.php';
?>