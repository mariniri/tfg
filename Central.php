<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Central
 *
 * @author antonio
 */
class Central {

    private $nombre;
    private $latitud;
    private $longitud;
    private $direccion;

    function __construct($nombre, $latitud, $longitud, $direccion) {
        $this->nombre = $nombre;
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->direccion = $direccion;
    }

    function getNombre() {
        return $this->nombre;
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

    function setNombre($nombre) {
        $this->nombre = $nombre;
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

    public function __toString() {
        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }

}
