<?php
    include '../includes/templates/header.php';
?>

    <main class="contenedor">
        <h1>Servicios</h1>
        <!-- Inlcuimos el template de las especialidades que se cargan desde la carpeta de template -->
        <?php
            $mostrar = NULL;
            include '../includes/templates/especialidad.php';
        ?>
    </main>

<?php
    include '../includes/templates/footer.php';
?>