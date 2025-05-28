<main class="formulario">
    <h1>Crear nueva especialidad</h1>

    <!-- Fragmento de código PHP para mostrar los errores que contenga el array, si es que tuviese alguno -->
    <?php foreach($errores as $error): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
        
    <a href="/especialidades/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data"> <!-- enctype nos permite leer mejor el contenido de los archivos que se envíen desde el formulario --> 
            
        <!-- Incluimos el template del formulario -->
        <?php include __DIR__ . '/formulario.php' ?> 

        <input type="submit" value="Crear Especialidad" class="boton-verde">
    </form>
</main>