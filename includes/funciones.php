<?php

//include 'app.php';

define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
define('CARPETA_IMAGENES_SERVICIOS', __DIR__ . '/../imagenes/servicios/');

function autenticar(): bool {
    session_start();

    // Devuelve true si NO está logueado
    return !isset($_SESSION['login']) || $_SESSION['login'] !== true;
}


function debug($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

// Escapar HTML
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}

?>