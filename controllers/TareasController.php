<?php

namespace Controllers;

use Model\Proyectos;
use Model\Tareas;

class TareasController{


    public static function index(){
        session_start();
        $proyectoId= $_GET['url'];
        if(!$proyectoId) header('Location: /proyectos');

        $proyecto= Proyectos::where('url',$proyectoId);
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /404');
            return;
        }
        $tareas= Tareas::belongsTo('proyectoId',$proyecto->id);

        echo json_encode(['tareas' => $tareas]);
    }

    public static function crear(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            session_start();

            $proyectoId= $_POST['proyectoId'];
            $proyecto= Proyectos::where('url',$proyectoId);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta= [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea= new Tareas($_POST);
            $tarea->proyectoId= $proyecto->id;
            $resultado = $tarea->guardar();
            if($resultado['resultado']){
                $respuesta= [
                    'tipo' => 'exito',
                    'id' => $resultado['id'],
                    'mensaje' => 'Tarea agregada correctamente',
                    'proyectoId' => $proyecto->id
                ];
                echo json_encode($respuesta);
            }
        }
    }
    public static function actualizar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();
            //Validar que el proyecto existe
            $proyecto= Proyectos::where('url',$_POST['proyectoId']);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta= [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tareas($_POST);
            $tarea->proyectoId= $proyecto->id;

            $resultado= $tarea->guardar();

            if($resultado){
                $respuesta= [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actualizado correctamente'
                ];
                echo json_encode($respuesta);
            }
        }
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            session_start();
            //Validar que el proyecto existe
            $proyecto= Proyectos::where('url',$_POST['proyectoId']);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta= [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tareas($_POST);

            $resultado= $tarea->eliminar();

            if($resultado){
                $respuesta= [
                    'tipo' => 'exito',
                    'resultado' => $resultado,
                    'mensaje' => 'Eliminado correctamente'
                ];
                echo json_encode($respuesta);
            }
        }
    }
}