<?php
    // Importamos el archivo de funciones
    require '../includes/app.php';
    // Generamos una variable bool para saber si un usuario se ha autenticado
    autenticar();
    // Si no está autenticado, lo redirigimos a la home de la página
   

    $resultado = $_GET['resultado'] ?? null;
    include '../includes/templates/header.php';
    
?>

    <main class="contenedor">
        <h1>Administrador de ClickSalud</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="creado">Servicio creado correctamente</p>
        <?php endif ?>    

        <a href="/admin/propiedades/servicios/index.php" class="boton-verde">Servicios</a>
        <a href="/admin/propiedades/especialidades/index.php" class="boton-verde">Especialidades</a>


    </main>

<?php
    include '../includes/templates/footer.php';
?>