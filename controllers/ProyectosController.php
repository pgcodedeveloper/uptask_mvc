<?php

namespace Controllers;

use Model\Proyectos;
use Model\Tareas;

class ProyectosController{

    public static function index(){

    }

    public static function actualizar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            session_start();
            isAuth();
            $proyecto= Proyectos::where('url',$_POST['url']);
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta= [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error'
                ];
                echo json_encode($respuesta);
                return;
            }

            $proyectoA= new Proyectos($_POST);
            $proyectoA->id= $proyecto->id;
            $proyectoA->propietarioId= $_SESSION['id'];
            $resultado= $proyectoA->guardar();
            if($resultado){
                $respuesta= [
                    'tipo' => 'exito',
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
            isAuth();
            $proyecto= Proyectos::where('url',$_POST['url']);
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta= [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error'
                ];
                echo json_encode($respuesta);
                return;
            }
            $proyectoEliminar= new Proyectos($_POST);
            $proyectoEliminar->id= $proyecto->id;
            $sql= "DELETE FROM tareas WHERE proyectoId =" . $proyecto->id;
            $proyectoEliminar->eliminarSQL($sql);
            $resultado= $proyectoEliminar->eliminar();
            if($resultado){
                $respuesta= [
                    'tipo' => 'exito',
                    'mensaje' => 'Eliminado'
                ];
                echo json_encode($respuesta);
            }

        }
    }
}