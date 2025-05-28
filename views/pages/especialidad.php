<main class="contenedor">
    <h1><?php echo $especialidad->nombre; ?></h1>

    <img class="servicio-imagen" src="../build/img/<?php echo $especialidad->imagen; ?>" alt="Imagen de la especialidad">

    <div class="servicio-texto">
        <p><?php echo $especialidad->descripcion_larga; ?></p>
        <p><?php echo $especialidad->descripcion_larga_2; ?></p>
    </div>
</main>

<section class="servicio-login">
    <div class="contenedor-servicio-login">
        <h2>¿Listo para reservar tus citas?</h2>
        <p>Empieza a usar nuestra aplicación hoy mismo y gestiona tus citas médicas con comodidad.</p>
        <a class="boton-verde" href="login.php">Iniciar sesión o crear cuenta</a>
    </div>
</section>