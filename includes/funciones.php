<?php

function autenticar() : bool {
    // Iniciamos la sesión
    session_start();

    // Comprobamos si el usuario está autenticado con el array asociativo de login que hemos definido cuando un usuario realiza el login
    $autenticado = $_SESSION['login'];
    if($autenticado){
        return true;
    } 

    return false; 
}

?>