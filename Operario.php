<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Operario
 *
 * @author antonio
 */
include_once 'Jornada.php';

class Operario {

    private $id;
    private $nombre;
    private $jornadas;

    function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->jornadas= Array();
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getJornadas() {
        return $this->jornadas;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setJornadas($jornadas) {
        $this->jornadas = $jornadas;
    }
    
     function addJornada($jornada) {
         $jornada->setOperario($this->id);
        $aux=$jornada->getFecha();
        $this->jornadas["$aux"] = $jornada;

    }

    public function __toString() {
        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }
    
    function getJornadaDia($fecha) {
        if (array_key_exists("$fecha", $this->jornadas)) {
            return $this->jornadas["$fecha"];
        } else {
            return null;
        }
    }
    
   
    

}
