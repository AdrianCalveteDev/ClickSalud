<?php
    // Iniciamos la sesión
    session_start();

    // Vaciamos el contenido de la superglobal SESSION para "liberar" la sesión del usuario
    $_SESSION = [];

    // Redirigimos al usuario a la página principal
    header('Location: /');

?>