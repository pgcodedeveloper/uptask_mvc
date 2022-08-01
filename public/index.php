<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\ProyectosController;
use Controllers\TareasController;
use MVC\Router;
$router = new Router();

$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);

$router->get('/crear',[LoginController::class,'crear']);
$router->post('/crear',[LoginController::class,'crear']);

$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);

$router->get('/reestablecer',[LoginController::class,'reestablecer']);
$router->post('/reestablecer',[LoginController::class,'reestablecer']);

$router->get('/mensaje',[LoginController::class,'mensaje']);
$router->get('/confirmar',[LoginController::class,'confirmar']);


//Rutas privadas
$router->get('/proyectos',[DashboardController::class, 'index']);
$router->get('/crear-proyecto', [DashboardController::class,'crear_proyecto']);
$router->post('/crear-proyecto', [DashboardController::class,'crear_proyecto']);
$router->get('/perfil', [DashboardController::class,'perfil']);
$router->post('/perfil', [DashboardController::class,'perfil']);
$router->get('/cambiar-password', [DashboardController::class,'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class,'cambiar_password']);
$router->get('/proyecto',[DashboardController::class,'proyecto']);


// API para las tareas

$router->get('/api/tareas',[TareasController::class,'index']);
$router->post('/api/tarea',[TareasController::class,'crear']);
$router->post('/api/tarea/actualizar',[TareasController::class,'actualizar']);
$router->post('/api/tarea/eliminar',[TareasController::class,'eliminar']);


// API para los proyectos
$router->get('/api/proyectos',[ProyectosController::class,'index']);
$router->post('/api/proyecto/actualizar',[ProyectosController::class,'actualizar']);
$router->post('/api/proyecto/eliminar',[ProyectosController::class,'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();