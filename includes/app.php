<?php

// Este app.php es nuestro orquestador, donde mandaremos llamar nuestras funciones, nuestras conexiones a la base de datos
// y el autoload que utilizaremos en las clases para la POO

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

// Nos conectamos a la base de datos
$baseDatos = conectarBD();

use App\Servicio;

Servicio::setBaseDatos($baseDatos);