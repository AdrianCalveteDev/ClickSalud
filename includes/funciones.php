<?php

//include 'app.php';

define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
define('CARPETA_IMAGENES_SERVICIOS', __DIR__ . '/../imagenes/servicios/');
define('CARPETA_IMAGENES_ESPECIALIDADES', __DIR__ . '/../imagenes/especialidades/');
define('MENSAJES_SERVICIOS', '/admin/propiedades/servicios/');
define('MENSAJES_ESPECIALIDADES', '/admin/propiedades/especialidades/');


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

// Mensajes de error
function mostrarMensaje($codigo, $seccion) {
    $mensaje = '';

    switch($codigo){
        case 1:
            $mensaje = $seccion . ' Creado correctamente';
            break;
        case 2:
            $mensaje = $seccion . ' Actualizado correctamente';
            break;
        case 3:
            $mensaje = $seccion . ' Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;         
    }
    return $mensaje;
}

?>