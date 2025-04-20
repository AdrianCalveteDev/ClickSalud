<?php
    include '../includes/templates/header.php';
?>

    <main class="contenedor">
        <h1>Servicios</h1>
    <div class="contenedor-especialidades">   
        <div class="especialidad">
            <h2>Odontología</h2>
            <svg xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 24 24" 
                fill="none" 
                stroke="#4CB8AD" 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                width="144" 
                height="144" 
                stroke-width="2" 
                data-darkreader-inline-stroke="" 
                style="--darkreader-inline-stroke: currentColor;">
                <path d="M12 5.5c-1.074 -.586 -2.583 -1.5 -4 -1.5c-2.1 0 -4 1.247 -4 5c0 4.899 1.056 8.41 2.671 10.537c.573 .756 1.97 .521 2.567 -.236c.398 -.505 .819 -1.439 1.262 -2.801c.292 -.771 .892 -1.504 1.5 -1.5c.602 0 1.21 .737 1.5 1.5c.443 1.362 .864 2.295 1.262 2.8c.597 .759 2 .993 2.567 .237c1.615 -2.127 2.671 -5.637 2.671 -10.537c0 -3.74 -1.908 -5 -4 -5c-1.423 0 -2.92 .911 -4 1.5z" />
                <path d="M12 5.5l3 1.5" />
            </svg>
            <p>Cuidado dental completo para una sonrisa impecable.</p>
            <a href="servicio.php" class="boton-verde-block">Ver detalles</a>
        </div> <!--ESPECIALIDAD-->
            <div class="especialidad">
                <h2>Estética</h2>
                <svg xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="#4CB8AD" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    width="144" 
                    height="144" 
                    stroke-width="2" 
                    data-darkreader-inline-stroke=""
                    style="--darkreader-inline-stroke: currentColor;">
                    <path d="M12 18.176a3 3 0 1 1 -4.953 -2.449l-.025 .023a4.502 4.502 0 0 1 1.483 -8.75c1.414 0 2.675 .652 3.5 1.671a4.5 4.5 0 1 1 4.983 7.079a3 3 0 1 1 -4.983 2.25z" />
                    <path d="M12 19v-10" />
                    <path d="M9 3l3 2l3 -2" />
                </svg>
                <p>Tratamientos para realizar la belleza natural.</p>
                <a href="servicio.php" class="boton-verde-block">Ver detalles</a>
            </div> <!--ESPECIALIDAD-->
            <div class="especialidad">
                <h2>Fisioterapia</h2>
                <svg xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    fill="none" 
                    stroke="#4CB8AD" 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    width="144" 
                    height="144" 
                    stroke-width="2" 
                    data-darkreader-inline-stroke="" 
                    style="--darkreader-inline-stroke: currentColor;">
                    <path d="M4 17m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    <path d="M4 22l4 -2v-3h12" />
                    <path d="M11 20h9" />
                    <path d="M8 14l3 -2l1 -4c3 1 3 4 3 6" />
                </svg>
                <p>Terapia fisica personalizada para la recuperación.</p>
                <a href="servicio.php" class="boton-verde-block">Ver detalles</a>
            </div> <!--ESPECIALIDAD-->
            <div class="especialidad">
            <h2>Podología</h2>
                <img class="especialidad-imagen" src="../build/img/feet.png" alt="Icono para la especialidad de Podología">
            <p>Cuidado experto para el bienestar de tus pies.</p>
            <a href="servicio.php" class="boton-verde-block">Ver detalles</a>
        </div> <!--ESPECIALIDAD-->
            <div class="especialidad">
                <h2>Dermatología</h2>
                    <img class="especialidad-imagen" src="../build/img/cleansing.png" alt="Icono para la especialidad de Dermatología">
                <p>Tratamientos que cuidan y realzan la salud de tu piel.</p>
                <a href="servicio.php" class="boton-verde-block">Ver detalles</a>
            </div> <!--ESPECIALIDAD-->
            <div class="especialidad">
                <h2>Psicología</h2>
                    <img class="especialidad-imagen" src="../build/img/brain.png" alt="Icono para la especialidad de Psicología">
                <p>Acompañamiento profesional para tu equilibrio emocional.</p>
                <a href="servicio.php" class="boton-verde-block">Ver detalles</a>
            </div> <!--ESPECIALIDAD-->
        </div><!--CONTENEDOR ESPECIALIDAD-->
    </main>

<?php
    include '../includes/templates/footer.php';
?>