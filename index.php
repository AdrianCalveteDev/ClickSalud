<?php
    include 'includes/templates/header.php';
?>

    <main class="contenedor">
        <h1>Reserva tu cita médica fácilmente</h1>
        <div class="hero">
            <div>
                <p>Agenda tus consultas médicas online de forma rápida, sencilla y segura. Elige entre especialidades como odontología, fisioterapia o estética, selecciona el profesional que mejor se adapte a ti y reserva tu cita sin complicaciones. ¡Todo desde la aplicación, sin llamadas ni esperas!</p>
                <a class="boton-verde" href="#">Empieza ahora</a>
            </div>
            <img class="hero-img" src="build/img/doctora.png" alt="">
        </div>

        <div class="beneficios-ventajas">
            <div class="beneficios-ventajas_icono">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 24 24" 
                 fill="none" 
                 stroke="#4CB8AD" 
                 stroke-linecap="round" 
                 stroke-linejoin="round" 
                 width="96" 
                 height="96" 
                 stroke-width="2" 
                 data-darkreader-inline-stroke="" 
                 style="--darkreader-inline-stroke: currentColor;"
                 color="#2F2F2F1">
             <path d="M3 12a9 9 0 0 0 5.998 8.485m12.002 -8.485a9 9 0 1 0 -18 0"></path> 
             <path d="M12 7v5"></path> 
             <path d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2"></path> 
             <path d="M18 15v2a1 1 0 0 0 1 1h1"></path> 
             <path d="M21 15v6"></path> 
            </svg> 
                <h3>Reserva 24/7</h3>
                <p>Revisa las citas disponibles y reserva en cualquier momento.</p>
            </div>
            <div class="beneficios-ventajas_icono">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 24 24" 
                 fill="none" 
                 stroke="#4CB8AD" 
                 stroke-linecap="round" 
                 stroke-linejoin="round" 
                 width="96" 
                 height="96" 
                 stroke-width="2" 
                 data-darkreader-inline-stroke="" 
                 style="--darkreader-inline-stroke: currentColor;"
                 color="#2F2F2F1">
             <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
             <path d="M12 8v3" />
             <path d="M12 14v.01" />
            </svg> 
                <h3>Recordatorios</h3>
                <p>No olvidarás nunca tus citas, nosotros te las recordamos.</p>
            </div>
            <div class="beneficios-ventajas_icono">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 24 24" 
                 fill="none" 
                 stroke="#4CB8AD" 
                 stroke-linecap="round" 
                 stroke-linejoin="round" 
                 width="96" 
                 height="96" 
                 stroke-width="2" 
                 data-darkreader-inline-stroke="" 
                 style="--darkreader-inline-stroke: currentColor;"
                 color="#2F2F2F1">
                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
            </svg> 
                <h3>Seguridad</h3>
                <p>Datos personales 100% protejidos</p>
            </div>
        </div>
    </main>

    <section class="contenedor">
        <h2>Especialidades destacadas</h2>
        
        <!-- Inlcuimos el template de las especialidades que se cargan desde la carpeta de template -->
        <?php
            $mostrar = 3;
            include 'includes/templates/especialidad.php';
        ?>

        <div class="alinear-derecha">
            <a href="pages/servicios.php" class="boton-verde">
                Ver todas
            </a>
        </div>
    </section>

    <section class="imagen-contactar">
        <h2>¿tienes dudas?</h2>
        <p>Rellena nuestro formulario de contacto y un especialista se pondrá en contacto contigo lo antes posible.</p>
        <a href="pages/contacto.php" class="boton-amarillo">Contáctanos</a>
    </section>

    <section class="contenedor-testimonios">
        <img src="build/img/resena.png" alt="">
        <div class="testimonios">
            <blockquote>
                Desde que utilizo ClickSalud puedo llevar mis citas al día sin que se me olvide nunca acudir a ninguna, además de la sencillez a la hora de conseguir cita con un especialista.
            </blockquote>
            <p>Pepe Pérez</p>
        </div>
    </section>

    

<?php
    include 'includes/templates/footer.php';
?>