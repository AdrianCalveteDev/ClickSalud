<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class UsuarioController{
    public static function crearUsuario(Router $router){

        $usuario = new Usuario;

        $errores = [];

        $errores = Usuario::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Creamos una instancia de nuestra clase Servicio
            $usuario = new Usuario($_POST['usuario']);

            // Asignamos a una variable errores nuestro metodo getter estatico para recoger los errores de validación
            $errores = $usuario->validar();

            $usuario->guardar(MENSAJES_NUEVO_USUARIO);
        }

        

        $router->render('auth/crearUsuario', [
            'errores' => $errores
        ]);
    }
}