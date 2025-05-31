<?php

namespace Controllers;

use Model\Admin;
use Model\Centro;
use MVC\Router;
use Model\Cita;
use Model\Especialidad;
use Model\Especialista;
use Model\Servicio;

class CitaController {
    
    public static function misCitas(Router $router) {

        $usuario_id = $_SESSION['usuario_id'];
        $usuario = Admin::buscar($usuario_id);
        $resultado = 0;
        
        // Creamos un mapa array con las especialidades para pasarselas a la vista
        $especialidades = Especialidad::all();
        $mapaEspecialidades = [];

        foreach ($especialidades as $especialidad) {
            if (isset($especialidad->id)) {
                $mapaEspecialidades[$especialidad->id] = $especialidad->nombre;
            }
        }

        // Creamos también un mapa array con los servicios para pasarselos a la vista
        $servicios = Servicio::all();
        $mapaServicios = [];

        foreach ($servicios as $servicio) {
            if (isset($servicio->id)) {
                $mapaServicios[$servicio->id] = $servicio->nombre;
            }
        }

        // Y un array para los especialistas
        $especialistas = Especialista::all();
        $mapaEspecialistas = [];

        foreach ($especialistas as $especialista) {
            if (isset($especialista->id)) {
                $mapaEspecialistas[$especialista->id] = $especialista->nombre . " " . $especialista->apellido;
            }
        }

        // Función para obtener todas las citas desde el id del usuario
        $citas = Cita::whereAll('usuario_id', $usuario_id);

        $router->render('citas/misCitas', [
            'citas' => $citas,
            'usuario' => $usuario,
            'especialidades' => $mapaEspecialidades,
            'servicios' => $mapaServicios,
            'especialistas' => $mapaEspecialistas,
            'resultado' => $resultado
        ]);
    }


    public static function crear(Router $router) {

        $cita = new Cita;
        $especialidades = Especialidad::all();
        $especialistas = Especialista::all();
        // $servicios = Servicio::all();
        $centros = Centro::all();
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST['cita'];
            $datos['usuario_id'] = $_SESSION['usuario_id']; // Asegúrate de guardar esto al iniciar sesión
            $cita = new Cita($datos);
            $errores = $cita->validar();

            if (empty($errores)) {
                $cita->guardar(MENSAJE_CITAS);
                header('Location: /citas/misCitas?resultado=1');
                exit;
            }
        }

        $router->render('citas/crear', [
            'cita' => $cita,
            'errores' => $errores,
            'especialidades' => $especialidades,
            'centros' => $centros,
            'especialistas' => $especialistas,
            'servicios' => []
        ]);
    }

    // API para obtener servicios según la especialidad seleccionada del usuario
    public static function obtenerServiciosPorEspecialidad() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $especialidad_id = $_POST['especialidad_id'] ?? null;

            if ($especialidad_id) {
                $servicios = Servicio::whereAll('especialidad_id', $especialidad_id);
                echo json_encode($servicios);
            }
        }
    }

    // API para obtener especialistas por la especialidad a la que se decian y al centro que están asociados
    public static function obtenerEspecialistas() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $especialidad_id = $_POST['especialidad_id'] ?? null;
            $centro_id = $_POST['centro_id'] ?? null;

            if ($especialidad_id && $centro_id) {
                $especialistas = Especialista::whereMultiple([
                    'especialidad_id' => $especialidad_id,
                    'centro_id' => $centro_id
                ]);
                echo json_encode($especialistas);
                return;
            }
        }
        echo json_encode([]);
    }

    public static function eliminar(){
        // Cuando se envíe el formulario de eliminar, asignamos a la variable el ID del servicio
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idCita = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if($idCita){
                // Obtenemos los datos del servicio
                $cita = Cita::buscar($idCita);
                $cita->eliminar(MENSAJES_SERVICIOS);
                header('Location: /citas/misCitas?resultado=3');       
            }   
        }
    }
}
