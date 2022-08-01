<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        
        $alertas= [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario= new Usuario($_POST);
            $alertas= $usuario->validarLogin();
            if(empty($alertas)){
                $usuario= Usuario::where('email',$usuario->email);
                if($usuario || $usuario->confirmado){
                    $resultado= $usuario->passwordLogin($_POST['password']);
                    if($resultado){
                        iniciarSesion($usuario->id,$usuario->nombre,$usuario->email,true);
                        header('Location: /proyectos');
                    }
                    else{
                        Usuario::setAlerta('error','El Password no es correcto');
                        $alertas= Usuario::getAlertas();
                    }
                }
                else{
                    Usuario::setAlerta('error','El Usuario No existe o no está confirmado');
                    $alertas= Usuario::getAlertas();
                    
                }
            }
        }
        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION= [];
        header('Location: /');
    }

    public static function crear(Router $router){
        $usuario= new Usuario;
        $alertas= [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas=$usuario->validar();
            
            if(empty($alertas)){
                $existeUser= Usuario::where('email',$usuario->email);
                if($existeUser){
                    Usuario::setAlerta('error','El Usuario ya existe');
                    $alertas= Usuario::getAlertas();
                }
                else{
                    //hash password
                    $usuario->hashPassword();
                    //eliminar el valor password2
                    unset($usuario->password2);
                    //crear el token
                    $usuario->crearToken();

                    $resultado= $usuario->guardar();
                    $email= new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }
       
        $router->render('auth/crear',[
            'titulo' => 'Crea tu cuenta en UpTask gratis',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
        $alertas= [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas= $usuario->validarEmail();

            if(empty($alertas)){
                $usuario= Usuario::where('email',$usuario->email);
                if($usuario && $usuario->confirmado === "1"){
                    unset($usuario->password2);
                    $usuario->crearToken();
                    $usuario->guardar();
                    $email= new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarConfirmacion();
                    Usuario::setAlerta('exito',"Hemos enviado las instrucciones a tu email");
                } 
                else{
                    Usuario::setAlerta('error','El Usuario no existe o no esta confirmado');
                }
            }
            $alertas= Usuario::getAlertas();
        }
        $router->render('auth/olvide',[
            'titulo' => 'Olvidé mi password',
            'alertas' => $alertas
        ]);
    }
    
    public static function reestablecer(Router $router){
        $alertas= [];
        $mostrar= true;
        $token= s($_GET['token']);
        if(!$token) header('location: /');

        $usuario= Usuario::where('token',$token);
        if(empty($usuario)){
            Usuario::setAlerta('error','Token No válido');
            $mostrar=false;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas= $usuario->validarPassword();
            if(empty($alertas)){
                $usuario->hashPassword();
                unset($usuario->password2);
                $usuario->token="";
                $resultado= $usuario->guardar();

                if($resultado){
                    header('location: /');
                }
            }
        }
        $alertas= Usuario::getAlertas();
        $router->render('auth/reestablecer',[
            'titulo' => "Crea tu nuevo Password",
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }
    public static function mensaje(Router $router){
        
        $router->render('auth/mensaje',[
            'titulo' => "Cuenta creada exitosamente"
        ]);
    }

    public static function confirmar(Router $router){
        $alertas= [];
        $token= s($_GET['token']);
        if(!$token){
            header('location: /');
        }
        $usuario= Usuario::where('token',$token);
        if(empty($usuario)){
            Usuario::setAlerta('error','Token No Válido');
        }
        else{
            $usuario->confirmado= 1;
            $usuario->token= "";
            unset($usuario->password2);
            $usuario->guardar();
            Usuario::setAlerta('exito','Token Válido, Cuenta confirmada');
        }
        $alertas= Usuario::getAlertas();
        $router->render('auth/confirmar',[
            'titulo' => "Confirma tu cuenta de UpTask",
            'alertas' => $alertas
        ]);
    }
}