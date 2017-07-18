<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jornada
 *
 * @author antonio
 */
include_once 'Tarea.php';

class Jornada {

    //Formato de fecha 2017-01-01 14:00
    private $inicio;
    private $fechaInicio;
    private $fin;
    private $fechaFin;
    private $total;
    private $tareas;
    private $fecha;
    private $operario;

    function __construct($inicio, $fin) {
        $this->inicio = strtotime($inicio);
        $this->fin = strtotime($fin);
        $this->total = $this->fin - $this->inicio;
        $this->fechaInicio = date('r', $this->inicio);
        $this->fechaFin = date('r', $this->fin);
        $this->tareas = Array();
        $this->fecha = explode(" ",$inicio)[0];
        
    }

    function comprobarDisponibilidad($tarea) {

        $esPosible = true;
        $cont = 0;
        while ($cont < count($this->tareas) && $esPosible) {
            if ($this->comprobarRango($this->tareas[$cont], $tarea) == false) {
                $esPosible = false;
            }

            $cont++;
        }

        return $esPosible;
    }

    function agregarTarea($tarea,$ordenar) {
        $seAgrego = false;
        if($this->total>=$tarea->getTotal()){
        if ($this->comprobarDisponibilidad($tarea)) {
            
            $this->tareas[count($this->tareas)] = $tarea;
            $this->total=$this->total-$tarea->getTotal();
            if(count($this->tareas)>1){
            usort($this->tareas, array("Tarea", $ordenar));
            
            }
            $seAgrego = true;
        }
        }
        return $seAgrego;
    }

    function comprobarRango($tareaA, $tareaB) {

        $fuera = true;
        //compromabos que la tareaB no solape por la izquierda
        //                                        tareaBInicio----tareaBFin
        //                                                   tareaAInicio----tareaAFin                                     
        //comprobamos que la tareaB no solape por la derecha
        //                                        tareaBInicio----tareaBFin
        //                                tareaAInicio----tareaAFin
        //comprobamos que la tareaB no solape por la centro
        //                                        tareaBInicio----tareaBFin
        //                                        tareaAInicio----tareaAFin
        
        if (
                (
                  ($tareaA->getInicio() <= $tareaB->getFin()) && ($tareaA->getInicio() >= $tareaB->getInicio())
                )
                || 
                (
                  ($tareaA->getFin() <= $tareaB->getFin()) && ($tareaA->getFin() >= $tareaB->getInicio())
                ) 
                || 
                (
                  ($tareaA->getInicio() >= $tareaB->getInicio()) && ($tareaA->getFin() <= $tareaB->getFin())
                )
        ) {

            $fuera = false;
        }

        return $fuera;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFin() {
        return $this->fin;
    }

    function getTareas() {
        return $this->tareas;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

    function setTareas($tareas) {
        $this->tareas = $tareas;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getTotal() {
        return $this->total;
    }
    
    
    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getOperario() {
        return $this->operario;
    }

    function setOperario($operario) {
        $this->operario = $operario;
    }

           

    public function __toString() {
        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }
    
   
    
    static function compareTiempoOcupado($jornadaA, $jornadaB) {
        
        if ($jornadaA->getTotal() == $jornadaB->getTotal()) {
            return 0;
        }
        return ($jornadaA->getTotal() > $jornadaB->getTotal()) ? -1 : 1;
    }
    
    

}
