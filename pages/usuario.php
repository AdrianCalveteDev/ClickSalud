<?php
    // Importar la conexión
    require '../includes/app.php';
    $baseDatos = conectarBD();

    // Crear un email y contraseña
    $nombre = "Pruebas";
    $apellido = "2";
    $email = "pruebas@correo.com";
    $contrasena = "123456";
    $creado_en = date('Y-m-d H:i:s');

    // Usamos la función de PHP para hashear la contraseña y securizar nuestra aplicación
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Query para crear el usuario
    $query = "INSERT INTO usuarios (nombre, apellido, email, contrasena_hash, creado_en)
              VALUES ('$nombre', '$apellido', '$email', '$contrasena_hash', '$creado_en');";

    // Agregarlo a la base de datos
    mysqli_query($baseDatos, $query);

    // Cerrar la conexión
    mysqli_close($baseDatos);

?>