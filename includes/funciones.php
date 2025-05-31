<?php

//include 'app.php';

define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');
define('CARPETA_IMAGENES_SERVICIOS', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/servicios/');
define('CARPETA_IMAGENES_ESPECIALIDADES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/especialidades/');
define('MENSAJES_SERVICIOS', '/servicios/admin');
define('MENSAJES_ESPECIALIDADES', '/especialidades/admin');
define('MENSAJES_NUEVO_USUARIO', '/crearUsuario');
define('MENSAJE_CITAS','/citas/misCitas');


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

function validarORedireccionar(string $url){
    // Variable con el ID del servicio, donde nos aseguramos de que solo pueda ser un dato de tipo integer
    // Esto evita que alguien intente pasar un dato no valido, evita SQL injection y XSS
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    // Si se pasa un dato que no es un INT, redirigimos al usuario al panel de administración de los servicios.
    if (!$id){
        header("Location: $url");
    }

    return $id;
}

?>