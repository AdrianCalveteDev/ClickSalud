<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController{
    public static function login(Router $router){

        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Creamos una nueva instancia del modelo Admin
            $auth = new Admin($_POST);

            // Generamos una variable errores validando dichos errores con la función validar de Active Record
            $errores= $auth->validar();

            // Si no hay errores
            if (empty($errores)){
                // Verificamos si el usuario existe
                $resultado = $auth -> usuarioExiste();

                if(!$resultado) {
                    // Si el usuario no existe -> mensaje de error
                    $errores = Admin::getErrores();
                } else {
                    // Verificiamos la contraseña
                    $autenticado = $auth->comprobarContrasena($resultado);

                    // Si el usuario se autentica
                    if ($autenticado){
                        // Autenticamos al usuario con la función definida en el modelo
                        $auth -> autenticar();
                    } else {
                        // Contraseña incorrecta -> mensaje de error
                        $errores = Admin::getErrores();
                    }
                }                
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout(){
        session_start();

        // Vacíamos la sesión
        $_SESSION = [];

        // Y redirigimos al usuario a la página principal
        header('Location: /');
    }
}