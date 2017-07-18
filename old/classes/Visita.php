<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Visitas
 *
 * @author marina
 */
class Visita {

    public $posicion;
    public $idvisita;
    public $horainicio;
    public $horafin;
    public $latitud;
    public $longitud;
    public $direccion;
    public $duracionestimada;
    public $inicio;
    public $fin;
    public $fecha; 
    
    function __construct($horainicio, $horafin, $latitud, $longitud, $direccion) {
        $this->inicio = strtotime($horainicio);
        $this->fin = strtotime($horafin);
        $this->horainicio = date('r', $this->inicio);
        $this->horafin = date('r', $this->fin);
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->direccion = $direccion;
        $this->fecha= explode(" ",$horainicio)[0];
        $this->duracionestimada=   $this->total = $this->fin - $this->inicio;
        
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFin() {
        return $this->fin;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

        function getDuracion() {
        return $this->duracionestimada;
    }

    
    function getHorainicio() {
        return $this->horainicio;
    }

    function getFecha(){
        return $this->fecha;
    }
    
    function getHorafin() {
        return $this->horafin;
    }

    function getLatitud() {
        return $this->latitud;
    }


    function getLongitud() {
        return $this->longitud;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function setHorainicio($horainicio) {
        $this->horainicio = $horainicio;
    }

    function setHorafin($horafin) {
        $this->horafin = $horafin;
    }

    function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    function setLongitud($longitud) {
        $this->longitud = $longitud;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    function getIdvisita() {
        return $this->idvisita;
    }

    function setIdvisita($idvisita) {
        $this->idvisita = $idvisita;
    }
    function getPosicion() {
        return $this->posicion;
    }

    function setPosicion($posicion) {
        $this->posicion = $posicion;
    }



}
