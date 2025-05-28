<?php

namespace Controllers;
use MVC\Router;
use Model\Especialidad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasPublicasController {
    public static function index(Router $router){
        
        $especialidades = Especialidad::all(3);

        $router->render('pages/index', [
            'especialidades' => $especialidades
        ]);
    }
    public static function nosotros(Router $router){
        $router->render('pages/nosotros');
    }
    public static function especialidades(Router $router){

        $especialidades = Especialidad::all();

        $router->render('pages/especialidades', [
            'especialidades' => $especialidades
        ]);
    }
    public static function especialidad(Router $router){

        // Revisamos que el id sea valido y si redireccionamos a especialidades
        $id = validarORedireccionar('/especialidades');

        // Buscamos la especialidad por ID
        $especialidad = Especialidad::buscar($id);

        $router->render('pages/especialidad', [
            'especialidad' => $especialidad
        ]);
    }
    public static function contacto(Router $router){

        $mensaje = null;
        $exito = null;
        $errores = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Respuestas del usuario
            $respuestas = $_POST['contacto'];
            
            // Crear instancia de PHP Mailer
            $email = new PHPMailer();

            // Configurar protocolo SMTP
            $email -> isSMTP();
            $email -> Host = 'sandbox.smtp.mailtrap.io';
            $email -> SMTPAuth = true;
            $email -> Username = '369b27dbe89676';
            $email -> Password = 'aff9c77fd3359f';
            $email -> SMTPSecure = 'tls';
            $email -> Port = 2525;

            // Configuración del contenido del email
            $email -> setFrom('admin@clicksalud.com');
            $email -> addAddress('admin@clicksalud.com', 'ClickSalud');
            $email -> Subject = 'Tienes un nuevo mensaje';

            // Habilitamos HTML
            $email -> isHTML(true);
            $email -> CharSet = 'UTF-8';

            // Contenido del correo
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';
            $contenido .= '<p>Apellido: ' . $respuestas['apellido'] . '</p>';
            

            if($respuestas['contacto'] === 'telefono')
            {
                $contenido .= '<p>Eligió ser contactado por teléfono:</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora de contacto: ' . $respuestas['hora'] . '</p>';

            } else {
                // Como se elige email, enviamos la información del campo email
                $contenido .= '<p>Eligió ser contactado por email:</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }

            
            $contenido .= '<p>Especialidad: ' . $respuestas['especialidad'] . '</p>';
            $contenido .= '<p>Contacto: ' . $respuestas['contacto'] . '</p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '</html>';
            
            $email -> Body = $contenido;

            // Mensajes de retroalimentación para el usuario, para saber si se ha enviado o no su contacto
            if(!$email -> send()){
                $mensaje = "El mensaje no se ha podido enviar...";
                $exito = false;
            } else {
                $mensaje = "Mensaje enviado correctamente";
                $exito = true;
            }
        }

        $router->render('pages/contacto', [
            'mensaje' => $mensaje,
            'exito' => $exito
        ]);
    }
    public static function faq(Router $router){
        $router->render('pages/faq');
    }
}