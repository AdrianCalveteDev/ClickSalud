<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class UsuarioController{
    public static function crearUsuario(Router $router){

        $usuario = new Usuario;

        $errores = [];

        $errores = Usuario::getErrores();

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Creamos una instancia de nuestra clase Servicio
            $usuario = new Usuario($_POST['usuario']);

            // Asignamos a una variable errores nuestro metodo getter estatico para recoger los errores de validación
            $errores = $usuario->validar();

            // Revisamos si el usuario no existe previamente en la base de datos (su email)
            $usuario->usuarioExiste();

            $errores = Usuario::getErrores();

            if(empty($errores)){
                // Encriptamos la contraseña antes de guardarla
                $usuario->contrasena_hash = password_hash($usuario->contrasena_hash, PASSWORD_DEFAULT);
                $usuario->guardar(MENSAJES_NUEVO_USUARIO);
                header('Location: /crearUsuario?exito=1');
                exit;
            }
        }

        $router->render('auth/crearUsuario', [
            'errores' => $errores,
            'mensaje' => $mensaje
        ]);
    }
}