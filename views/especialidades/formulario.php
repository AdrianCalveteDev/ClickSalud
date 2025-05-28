<fieldset>
    <legend>Información de la especialidad</legend>

    <label for="nombre">Nombre especialidad:</label>
    <input name="especialidad[nombre]" type="text" placeholder="Nombre de la especialidad" value="<?php echo s($especialidad->nombre); ?>">

    <label for="descripcion">Descripción:</label>
    <textarea name="especialidad[descripcion]" id="descripcion" placeholder="Descripción de la especialidad"><?php echo s($especialidad->descripcion);?></textarea>

    <label for="logo">Logo</label>
    <input name="especialidad[logo]" type="file" id="logo" accept="image/png, image/jpeg">

    <?php if($especialidad->logo){ ?>
        <img src="/imagenes/especialidades/<?php echo $especialidad->logo ?>" class="servicio-imagen" alt="Logo de la especialidad">
    <?php } ?>

    <label for="imagen">Imágen</label>
    <input name="especialidad[imagen]" type="file" id="imagen" accept="image/png, image/jpeg">

    <?php if($especialidad->imagen){ ?>
        <img src="/imagenes/especialidades/<?php echo $especialidad->imagen ?>" class="servicio-imagen" alt="Imágen del servicio">
    <?php } ?>    
</fieldset>