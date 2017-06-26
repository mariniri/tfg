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
    public $fecha;
    public $duracionestimada;
    
    function __construct($fecha,$horainicio, $horafin, $latitud, $longitud, $direccion, $duracionestimada) {
        $this->horainicio = $horainicio;
        $this->horafin = $horafin;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->direccion = $direccion;
        $this->fecha = $fecha;
        $this->duracionestimada=$duracionestimada;
    }

    function getDuracion() {
        return $this->duracionestimada;
    }

    function setDuracion($duracion) {
        $this->duracionestimada = $duracion;
    }
    
    function getHorainicio() {
        return $this->horainicio;
    }

    function getHorafin() {
        return $this->horafin;
    }

    function getLatitud() {
        return $this->latitud;
    }

    function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
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
