<?php

// Función que conecta a la base de datos donde le especificamos que nos debe devolver un objeto del tipo "mysqli"
function conectarBD() : mysqli{
    // Con mysqli, mediante los parámetros que le enviamos creamos la conexión hacía nuestra base de datos
    $baseDatos = new mysqli('localhost', 'root', '', 'clicksalud');

    // Si no se produce la conexión, arrojamos error y paramos la ejecución
    if (!$baseDatos){
        echo "Hubo un error, no se conectó a la base de datos";
        exit;
    }

    // Si todo es correcto devolvemos el objeto del tipo mysqli
    return $baseDatos;
}