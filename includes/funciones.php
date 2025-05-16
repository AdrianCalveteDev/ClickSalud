<?php

// include 'app.php';

define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
define('CARPETA_IMAGENES_SERVICIOS', __DIR__ . '/../imagenes/servicios/');

function autenticar() : bool {
    // Iniciamos la sesión
    session_start();

    // Comprobamos si el usuario está autenticado con el array asociativo de login que hemos definido cuando un usuario realiza el login
    if(!$_SESSION['login']){
        return true;
    } 

    return false; 
}

function debug($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

?>