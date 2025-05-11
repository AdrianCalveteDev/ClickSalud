<?php
    // Importar base de datos
    require __DIR__ . '/../config/database.php';
    $baseDatos = conectarBD();
    // Consultar especialidades
    $queryEspecialidad = "SELECT * FROM especialidades";
    $queryEspecialidadLimitada = "SELECT * FROM especialidades LIMIT $mostrar";

    // Obtener resultado
    // Usamos un condicional para mostrar un número limitado de especialidades en la home y todas en la página de servicios
    if (empty($mostrar)) {
        $resultado = mysqli_query($baseDatos, $queryEspecialidad);
    } else {
        $resultado = mysqli_query($baseDatos, $queryEspecialidadLimitada);
    }
?>

<div class="contenedor-especialidades">
    <?php while($especialidad = mysqli_fetch_assoc($resultado)): ?>
        <div class="especialidad">
            <h2><?php echo $especialidad['nombre'];?></h2>
                <img class="especialidad-imagen" src="../build/img/<?php echo $especialidad['logo'];?>" alt="Icono para la especialidad de Odontología">
            <p><?php echo $especialidad['descripcion'];?></p>
            <a href="../../pages/servicio.php?id=<?php echo $especialidad['id'];?>" class="boton-verde-block">Ver detalles</a>
        </div> <!--ESPECIALIDAD-->
    <?php endwhile; ?>
</div><!--CONTENEDOR ESPECIALIDAD-->

<?php
    //Cerrar la conexión
    mysqli_close($baseDatos);
?>