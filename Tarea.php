<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tarea
 *
 * @author antonio
 */
class Tarea {

    //Formato de fecha 2017-01-01 14:00
    private $inicio;
    private $horaInicio;
    private $fin;
    private $horaFin;
    private $total;
    private $latitud;
    private $longitud;
    private $distanciaCentral;
    private $fecha;
    private $direccion;
    private $id;

    function __construct($inicio, $total, $latitud, $longitud, $id) {

        $this->total = $total;
        $this->inicio = strtotime($inicio);
        // $this->fechaInicio = date('r', $this->inicio);
        // $this->fechaFin = date("Y-m-d H:i", strtotime('+' . $total . ' minutes', $this->inicio));
        //  $this->fechaFin = date("r", strtotime('+' . $total . ' minutes', $this->inicio));
        $this->latitud = $latitud;
        $this->longitud = $longitud;
        $this->fecha = explode(" ", $inicio)[0];
        $this->id = $id;
    }

    function getHoraInicio() {
        return $this->horaInicio;
    }

    function getHoraFin() {
        return $this->horaFin;
    }

    function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }

    function getId() {
        return $this->id;
    }

    function setId($idtarea) {
        $this->id = $idtarea;
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

    function getLatitud() {
        return $this->latitud;
    }

    function getLongitud() {
        return $this->longitud;
    }

    function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    function setLongitud($longitud) {
        $this->longitud = $longitud;
    }

    function getDistanciaCentral() {

        return $this->distanciaCentral;
    }

    function getDistanciaCentralDos($c) {
        $dist = new Distance();
        $dc= $dist->betweenCentral($this, $c, "time");
        return floatval($dc);
    }

    function setDistanciaCentral($distanciaCentral) {
        $this->distanciaCentral = $distanciaCentral;
    }

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function distancia($tarea, $unit = "K") {

        $theta = $this->longitud - $tarea->getLongitud();
        $dist = sin(deg2rad($this->latitud)) * sin(deg2rad($tarea->getLatitud())) + cos(deg2rad($this->latitud)) * cos(deg2rad($tarea->getLatitud())) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function __toString() {

        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }

    static function compare($tareaA, $tareaB) {

        if ($tareaA->getInicio() == $tareaB->getInicio()) {
            return 0;
        }
        return ($tareaA->getInicio() < $tareaB->getInicio()) ? -1 : 1;
    }

    static function compareDistancias($tareaA, $tareaB) {

        if ($tareaA->getDistanciaCentral() == $tareaB->getDistanciaCentral()) {
            return 0;
        }
        return ($tareaA->getDistanciaCentral() < $tareaB->getDistanciaCentral()) ? -1 : 1;
    }

}
