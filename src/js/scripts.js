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

/* Muestra telefono o mail en función a lo que seleccione el usuario */
const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));    

function mostrarMetodosContacto(evento){
    const contactoDiv = document.querySelector('#contacto');
    if(evento.target.value === 'telefono'){
        contactoDiv.innerHTML = `
            <label for="telefono">Número teléfono</label>
            <input type="tel" id="telefono" placeholder="Tu teléfono..." name="contacto[telefono]" required>

            <p>Elija la fecha y la hora para ser contactado:</p>
            
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="contacto[fecha]" required>

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="20:00" name="contacto[hora]" required>
        `;
    } else {
        contactoDiv.innerHTML = `
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Tu correo..." name="contacto[email]" required>
        `;
    }
}

/* Llamada Ajax al Endpoint de servicios, utilizado en el formulario para crear citas, donde al usuario le mostraremos los servicios en función de la especialidad seleccionada */
document.addEventListener('DOMContentLoaded', function() {
    const especialidadSelect = document.querySelector('#especialidad');
    const servicioSelect = document.querySelector('#servicio');

    especialidadSelect.addEventListener('change', function() {
        const especialidadId = this.value;

        if (!especialidadId) {
            servicioSelect.innerHTML = '<option value="">-- Seleccione una especialidad primero --</option>';
            servicioSelect.disabled = true;
            return;
        }

        fetch('/api/servicios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `especialidad_id=${especialidadId}`
        })
        .then(response => response.json())
        .then(servicios => {
            servicioSelect.innerHTML = '<option value="">-- Seleccione --</option>';
            servicios.forEach(servicio => {
                const option = document.createElement('option');
                option.value = servicio.id;
                option.textContent = servicio.nombre;
                servicioSelect.appendChild(option);
            });
            servicioSelect.disabled = false;
        });
    });
});

/* Llamada Ajax al endpoint de especialistas para solamente mostrar los especialistas según el centro y la especialidad seleccionadas */
document.addEventListener('DOMContentLoaded', function() {
    const especialidadSelect = document.querySelector('#especialidad');
    const centroSelect = document.querySelector('#centro');
    const especialistaSelect = document.querySelector('#especialista');

    function cargarEspecialistas() {
        const especialidadId = especialidadSelect.value;
        const centroId = centroSelect.value;
        const mensaje = document.querySelector('#mensaje-especialistas');

        if (!especialidadId || !centroId) {
            especialistaSelect.innerHTML = '<option value="">-- Seleccione especialidad y centro primero --</option>';
            especialistaSelect.disabled = true;
            mensaje.style.display = 'none';
            return;
        }

        fetch('/api/especialistas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `especialidad_id=${especialidadId}&centro_id=${centroId}`
        })
        .then(response => response.json())
        .then(especialistas => {
            especialistaSelect.innerHTML = '';
            if (especialistas.length === 0) {
                especialistaSelect.disabled = true;
                especialistaSelect.innerHTML = '<option value="">-- No hay especialistas disponibles, seleccione otro centro--</option>';
                mensaje.style.display = 'block';
            } else {
                especialistaSelect.innerHTML = '<option value="">-- Seleccione --</option>';
                especialistas.forEach(especialista => {
                    const option = document.createElement('option');
                    option.value = especialista.id;
                    option.textContent = `${especialista.nombre} ${especialista.apellido}`;
                    especialistaSelect.appendChild(option);
                });
                especialistaSelect.disabled = false;
                mensaje.style.display = 'none';
            }
        });
    }

    especialidadSelect.addEventListener('change', cargarEspecialistas);
    centroSelect.addEventListener('change', cargarEspecialistas);
});



