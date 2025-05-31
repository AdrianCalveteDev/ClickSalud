<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\ServicioController;
use Controllers\EspecialidadController;
use Controllers\LoginController;
use Controllers\PaginasPublicasController;
use Controllers\UsuarioController;
use Controllers\CitaController;

$router = new Router();

// Routing del CRUD para Servicios
$router->get('/admin',[ServicioController::class, 'dashboard']);
$router->get('/servicios/admin',[ServicioController::class, 'index']);
$router->get('/servicios/crear',[ServicioController::class, 'crear']);
$router->post('/servicios/crear',[ServicioController::class, 'crear']);
$router->get('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar',[ServicioController::class, 'eliminar']);

// Routing para las especialidades
$router->get('/especialidades/admin',[EspecialidadController::class, 'index']);
$router->get('/especialidades/crear',[EspecialidadController::class, 'crear']);
$router->post('/especialidades/crear',[EspecialidadController::class, 'crear']);
$router->get('/especialidades/actualizar',[EspecialidadController::class, 'actualizar']);
$router->post('/especialidades/actualizar',[EspecialidadController::class, 'actualizar']);
$router->post('/especialidades/eliminar',[EspecialidadController::class, 'eliminar']);

// Routing para las páginas públicas
$router->get('/', [PaginasPublicasController::class, 'index']);
$router->get('/nosotros', [PaginasPublicasController::class, 'nosotros']);
$router->get('/especialidades', [PaginasPublicasController::class, 'especialidades']);
$router->get('/especialidad', [PaginasPublicasController::class, 'especialidad']);
$router->get('/contacto', [PaginasPublicasController::class, 'contacto']);
$router->post('/contacto', [PaginasPublicasController::class, 'contacto']);
$router->get('/faq', [PaginasPublicasController::class, 'faq']);

// Login y autenticación
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Creación de usuarios
$router->get('/crearUsuario', [UsuarioController::class, 'crearUsuario']);
$router->post('/crearUsuario', [UsuarioController::class, 'crearUsuario']);

// Citas
$router->get('/citas/misCitas', [CitaController::class, 'misCitas']);
$router->get('/citas/crear', [CitaController::class, 'crear']);
$router->post('/citas/crear', [CitaController::class, 'crear']);
$router->post('/citas/eliminar', [CitaController::class, 'eliminar']);

// APIS
$router->post('/api/servicios', [CitaController::class, 'obtenerServiciosPorEspecialidad']); // Endpoint
$router->post('/api/especialistas', [CitaController::class, 'obtenerEspecialistas']); // Endpoint


$router->comprobarRutas();