/* Menú hamburguesa en versión responsive */
document.addEventListener("DOMContentLoaded", function() {
    // Declaramos las constantes
    const contenedorEnlaces = document.querySelector('.header-nav_enlaces');
    const menuHamburguesa = document.querySelector('.menu-hamburguesa');

    // Con el evento click del menú hamburguesa...
    menuHamburguesa.addEventListener('click', function(){
        // alterna la clase activo en los enlaces
        contenedorEnlaces.classList.toggle('activo');
    });
});


/* Desplegar preguntas en FAQ */
document.addEventListener("DOMContentLoaded", function () {
    const faqPreguntas = document.querySelectorAll(".faq-pregunta h3");

    // Recorremos cada pregunta para aplicarle los mismos efectos.
    faqPreguntas.forEach(pregunta => {
        pregunta.addEventListener("click", function () {
            // Definimos la variable asociandola al siguiente elemento hermano
            let respuesta = this.nextElementSibling;
            // Variable para mostrar un elemento desde CSS
            let eSvisible = (respuesta.style.display === "block");

            // Mientras que el siguiente elemento hermano que sea un párrafo...
            while (respuesta && respuesta.tagName === "P") {
                // Con el ternario: Si el elemento el block lo cambiamos a none, si no, lo mantenemos.
                respuesta.style.display = eSvisible ? "none" : "block";
                respuesta = respuesta.nextElementSibling;
            }

            // Orientamos la flecha abajo si está desplegado y a la derecha si no con los estilos ya definidos en el CSS
            this.classList.toggle("flecha-abierta", !eSvisible); // Cambiar orientación de la flecha en CSS
        });
    });
});