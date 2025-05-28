<div class="contenedor-especialidades">
    <?php foreach($especialidades as $especialidad) {?>
        <div class="especialidad">
            <h2><?php echo $especialidad->nombre;?></h2>
                <img class="especialidad-imagen" src="../build/img/<?php echo $especialidad->logo;?>" alt="Icono para la especialidad de Odontología">
            <p><?php echo $especialidad->descripcion;?></p>
            <a href="/especialidad?id=<?php echo $especialidad->id;?>" class="boton-verde-block">Ver detalles</a>
        </div> <!--ESPECIALIDAD-->
    <?php } ?>    
</div><!--CONTENEDOR ESPECIALIDAD-->