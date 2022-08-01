<?php

namespace Model;

class Proyectos extends ActiveRecord{

    protected static $tabla='proyectos';
    protected static $columnasDB=['id','proyecto','url','propietarioId'];

    public $id;
    public $proyecto;
    public $url;
    public $propietarioId;

    public function __construct($args= [])
    {
        $this->id= $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }

    public function validar(){
        if(!$this->proyecto){
            self::$alertas['error'][]= "Debe ingresar un nombre de Proyecto";
        }

        return self::$alertas;
    }
}