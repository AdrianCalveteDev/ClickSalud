
<?php
    if(!isset($_SESSION)){
        session_start();
    }
    
    $autenticado = $_SESSION['login'] ?? false;
    $rol = $_SESSION['rol'] ?? null; 
    
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

                <img class="menu-hamburguesa" src="/build/img/menu-hamburguesa.png" alt="">
                <nav class="header-nav_enlaces">
                    <!-- Menú hamburguesa -->
                    <a href="/nosotros">Nosotros</a>
                    <a href="/especialidades">Especialidades</a>
                    <!--<a href="../pages/blog.php">Blog</a>-->
                    <a href="/contacto">Contacto</a>
                    <a href="/faq">FAQ</a>
                    <!-- Mostramos opciones por rol-->
                    <?php if($rol === 'admin'): ?>
                        <a href="/admin">Administrador</a>
                    <?php elseif ($rol === 'usuario'): ?>
                        <a href="/citas/misCitas">Mis citas</a>
                    <?php endif; ?>

                    <!-- Según esté autenticado o no, mostramos una opción u otra-->
                    <?php if(!$autenticado): ?>
                        <a class="header-nav_enlaces-enlace" href="/login">Iniciar sesión</a>
                    <?php elseif ($autenticado): ?>
                        <a class="header-nav_enlaces-enlace" href="/logout">Cerrar sesión</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <?php echo $contenido ?>

    <footer>
        <div class="contenedor contenedor-footer">
            <nav class="header-nav_enlaces">
                <a href="/nosotros">Nosotros</a>
                <a href="/especialidades">Especialidades</a>
                <!--<a href="/pages/blog.php">Blog</a>-->
                <a href="/contacto">Contacto</a>
                <a href="/faq">FAQ</a>
            </nav>
        </div>

        <p class="licencia">ClickSalud&copy; <?php echo date('Y') ?>. Todos los derechos reservados.</p>
    </footer>

    <script src="/build/js/scripts.js"></script>
</body>
</html>