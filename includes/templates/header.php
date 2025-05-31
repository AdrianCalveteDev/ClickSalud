<?php
    // Comprobamos que la variable de sesión no está iniciada para caso contrario mantener la sesión del usuario desde el header
    if(!isset($_SESSION)){
        session_start();
    }

    // Declaramos la variable autenticado al contenido de login de la suberglobal SESSION y si no existe le asignamos valor null
    $autenticado = $_SESSION['login'] ?? false;
    $rol = $_SESSION['rol'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClickSalud</title>
    <link rel="icon" href="/build/img/iconoClickSalud.png" type="image/png">
    <link rel="stylesheet" href="/build/css/styles.css">
</head>
<body>
    <header class="header">
        <div class="contenedor-header">
            <div class="header-nav">
                <a class="header-logo" href="/">
                    <img src="/build/img/logoClickSaludSmall.png" alt="Logotipo de Click salud">
                </a>

                <img class="menu-hamburguesa" src="../../build/img/menu-hamburguesa.png" alt="">
                <nav class="header-nav_enlaces">
                    <!-- Menú hamburguesa -->
                    <a href="../pages/nosotros.php">Nosotros</a>
                    <a href="../pages/servicios.php">Servicios</a>
                    <!--<a href="../pages/blog.php">Blog</a>-->
                    <a href="../pages/contacto.php">Contacto</a>
                    <a href="../pages/faq.php">FAQ</a>
                    <!-- Mostramos opciones por rol-->
                    <?php if($rol === 'admin'): ?>
                        <a href="../../admin/">Administrador</a>
                    <?php endif; ?>
                    <!-- Según esté autenticado o no, mostramos una opción u otra-->
                    <?php if(!$autenticado): ?>
                        <a class="header-nav_enlaces-enlace" href="../pages/login.php">Iniciar sesión</a>
                    <?php elseif ($autenticado): ?>
                        <a class="header-nav_enlaces-enlace" href="../pages/logout.php">Cerrar sesión</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>