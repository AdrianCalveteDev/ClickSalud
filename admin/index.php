<?php
    // Importamos el archivo de funciones
    require '../includes/funciones.php';
    // Generamos una variable bool para saber si un usuario se ha autenticado
    $autenticado = autenticar();

    // Si no está autenticado, lo redirigimos a la home de la página
    if(!$autenticado){
        header('Location: /');
    }

    $resultado = $_GET['resultado'] ?? null;
    include '../includes/templates/header.php';
    
?>

    <main class="contenedor">
        <h1>Administrador de ClickSalud</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="creado">Servicio creado correctamente</p>
        <?php endif ?>    

        <a href="/admin/propiedades/servicios/index.php" class="boton-verde">Servicios</a>

    </main>

<?php
    include '../includes/templates/footer.php';
?>