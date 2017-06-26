<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Itinerario
 *
 * @author marina
 */
class Itinerario {
    
    private $iditinerario;
    private $fecha;
    private $minutoslibres;
    private $listavisitas;
    
    function __construct($fecha, $minutoslibres) {
        $this->fecha = $fecha;
        $this->minutoslibres = $minutoslibres;
        $this->listavisitas = Array();
    }
    
    function getFecha(){
        return $this->fecha;
    }
    function getMinutoslibres(){
        return $this->minutoslibres;
    }
    
    function setFecha($fecha){
        $this->fecha =$fecha;
    }
    
    function setListavisitas($listavisitas){
        $this->listacitas=$listavisitas;
    }
    
    function getListavisitas(){
        return $this->listavisitas;
    }
    
    function setMinutoslibres($minutoslibres){
        $this->minutoslibres = $minutoslibres;
    }

    function getNumvisitas() {
        return sizeof($this->listavisitas);
    }

    function getIditinerario() {
        return $this->iditinerario;
    }

    function setIditinerario($iditinerario) {
        $this->iditinerario = $iditinerario;
    }

            
    function anadirVisita($visita){
        $aux= get_object_vars($visita);
        if($aux['fecha'] == $this->fecha){ 
            $this->listavisitas[$this->getNumvisitas()] = $visita;
        }else{
            echo "la fecha de la visita no se corresponde con la del itinerario";
        }
    }    
    function eliminarVisita($visita){
        $encontrado=false;
        $i=0;
        while($encontrado==false && $i<$this->getNumvisitas()){
            if($this->listavisitas[$i]==$visita){
                $encontrado = true;
                unset($this->listavisitas[$i]);
                echo "visita ELIMINADA";
            }
            $i++;
        }
    }
}
