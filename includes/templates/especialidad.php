<?php

    use App\Especialidad;

     // Hacemos obligatorio la inclusión del fichero que contiene la información para conectarse a la base de datos
    require_once __DIR__ . '/../app.php';

    // Si el cript name de la variable global $_SERVER tiene la URI indicada, entonces traemos todos los datos
    if ($_SERVER['SCRIPT_NAME'] === '/pages/servicios.php') {
        $especialidades = Especialidad::all();
        // Si no... lo limitamos a 3
    } else {
        $especialidades = Especialidad::all(3);
    }
?>

<div class="contenedor-especialidades">
    <?php foreach($especialidades as $especialidad) {?>
        <div class="especialidad">
            <h2><?php echo $especialidad->nombre;?></h2>
                <img class="especialidad-imagen" src="../build/img/<?php echo $especialidad->logo;?>" alt="Icono para la especialidad de Odontología">
            <p><?php echo $especialidad->descripcion;?></p>
            <a href="../../pages/servicio.php?id=<?php echo $especialidad->id;?>" class="boton-verde-block">Ver detalles</a>
        </div> <!--ESPECIALIDAD-->
    <?php } ?>    
</div><!--CONTENEDOR ESPECIALIDAD-->