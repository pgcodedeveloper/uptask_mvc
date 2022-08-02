<?php

namespace Controllers;

use Model\Proyectos;
use Model\Usuario;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){
        session_start();

        isAuth();
        $idUser= $_SESSION['id'];
        $proyectos= Proyectos::belongsTo('propietarioId',$idUser);
        $router->render('dashboard/index',[
            'titulo' => "Proyectos",
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto(Router $router){

        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $proyecto = new Proyectos($_POST);

            $alertas= $proyecto->validar();
            if(empty($alertas)){
                // Generar una URL única
                $proyecto->url= md5(uniqid());

                //Almacenar el id del User
                $proyecto->propietarioId= $_SESSION['id'];

                //Guardar
                $proyecto->guardar();

                //Redireccionar

                header('Location: /proyecto?url=' . $proyecto->url);
            }
        }

        $router->render('dashboard/crear-proyectos',[
            'titulo' => "Crear Proyectos",
            'alertas' => $alertas
        ]);
    }

    public static function perfil(Router $router){

        session_start();
        isAuth();

        $alertas= [];

        $usuario= Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas= $usuario->validar_perfil();

            if(empty($alertas)){


                $existeUser= Usuario::where('email',$usuario->email);

                if($existeUser && $existeUser->id !== $usuario->id){
                    // Mensaje de error
                    Usuario::setAlerta('error','Email no válido, ya pertenece a otra cuenta');
                }
                else{
                    // Guardar los cambios
                    $usuario->guardar();

                    //Alerta de exito
                    Usuario::setAlerta('exito','Guardado Correctamente');
                    $alertas= $usuario->getAlertas();

                    //Cambiar los datos de la sesion
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;
                }
                
            }
        }

        $router->render('dashboard/perfil',[
            'titulo' => "Perfil",
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function cambiar_password(Router $router){

        session_start();
        isAuth();

        $alertas= [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario= Usuario::find($_SESSION['id']);

            $usuario->sincronizar($_POST);
            $alertas= $usuario->validarPasswordPerfil();

            if(empty($alertas)){
                $resultado= $usuario->comprobar_password();

                if($resultado){
                    //Asignar el nuevo password
                    $usuario->password= $usuario->password_nuevo;

                    //Eliminar las propiedades que no son necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //Hash al nuevo password
                    $usuario->hashPassword();

                    //Guardar los cambios
                    $resultado= $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta('exito','Password cambiado correctamente');
                        $alertas= Usuario::getAlertas();
                    }
                }
                else{
                    Usuario::setAlerta('error','Password incorrecto');
                    $alertas= Usuario::getAlertas();
                }
            }
        }
        $router->render('dashboard/cambiar-password',[
            'titulo' => 'Cambiar tu Password',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        $url= $_GET['url'];

        if($url){
            $proyecto= Proyectos::where('url',$url);
            if($proyecto->propietarioId !== $_SESSION['id']){
                header('Location: /proyectos');
            }
        }
        else{
            header('Location: /proyectos');
        }

        $router->render('dashboard/proyecto',[
            'titulo' => $proyecto->proyecto,
            'proyecto' => $proyecto
        ]);
    }
}