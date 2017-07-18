<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tareas
 *
 * @author antonio
 */
class Tareas {

    //Formato de fecha 2017-01-01 14:00
    private $inicio;
    private $fechaInicio;
    private $fin;
    private $fechaFin;
    private $total;
    

    function __construct($inicio, $fin) {

        $this->inicio = strtotime($inicio);
        $this->fin = strtotime($fin);
        $this->total = $this->fin - $this->inicio;
        $this->fechaInicio=date('r', $this->inicio);
        $this->fechaFin=date('r', $this->fin);
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFin() {
        return $this->fin;
    }

    function getTotal() {
        return $this->total;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }
    
    function getFechaFin() {
        return $this->fechaFin;
    }

    public function __toString() {

        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }

}
