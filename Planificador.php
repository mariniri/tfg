<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Planificador
 *
 * @author antonio
 */
include_once 'Tarea.php';
include_once 'Operario.php';

class Planificador {

    private $operarios;
    private $tareas;
    private $central;
    private $pendientes;
    private $matrix;

    function __construct($operarios, $tareas, $central) {
        $this->operarios = $operarios;
        $this->tareas = $tareas;
        $this->central = $central;
        $this->calcularDistanciaCentral();
        usort($this->tareas, array("Tarea", "compareDistancias"));
        $this->matrizDistancias("time", $this->tareas);
    }

    function getOperarios() {
        return $this->operarios;
    }

    function getTareas() {
        return $this->tareas;
    }

    function getCentral() {
        return $this->central;
    }

    function setOperarios($operarios) {
        $this->operarios = $operarios;
    }

    function setTareas($tareas) {
        $this->tareas = $tareas;
    }

    function setCentral($central) {
        $this->central = $central;
    }

    function getPendientes() {
        return $this->pendientes;
    }

    function setPendientes($pendientes) {
        $this->pendientes = $pendientes;
    }

    function matrizDistancias($type, $allTareas) {
        $distance = new Distance();
        $this->matrix = ($type == "time") ? $distance->getTimeMatrix($allTareas) : $distance->getDistMatrix($allTareas);
    }

    function getMatrix() {
        return $this->matrix;
    }

    function setMatrix($matrix) {
        $this->matrix = $matrix;
    }

    function distancia($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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

    function calcularDistanciaCentral() {
        //calcularse con google maps

        for ($i = 0; $i < count($this->tareas); $i++) {
            $this->tareas[$i]->setDistanciaCentral($this->tareas[$i]->distancia($this->central, "K"));
        }
    }

    function calcularDistanciaCentralOrigen($auxTareas, $origen, $cont) {

        for ($i = $cont; $i < count($auxTareas); $i++) {
            $auxTareas[$i]->setDistanciaCentral($auxTareas[$i]->distancia($origen, "K"));
        }

        return $auxTareas;
    }

    function distribuirTareas($fecha) {

        $auxJornadas = Array();

        foreach ($this->operarios as $operario) {

            if (($aux = $operario->getJornadaDia($fecha))) {
                array_push($auxJornadas, $aux);
            }
        }

        $auxTareas = $this->tareas;
        $totalTareas = count($auxTareas);
        $totalJornadas = count($auxJornadas);

        $contT = 0;
        $contJ = 0;
        while ($contJ < $totalJornadas && $contT < $totalTareas) {
            $jornada = $auxJornadas[$contJ];
            $tarea = $auxTareas[$contT];
            while ($contT < $totalTareas) {
                if ($jornada->getTotal() >= $tarea->getTotal()) {
                    echo $jornada . " " . $tarea;
                }
                $contT++;
            }
            $contT = 0;
            $contJ++;
        }




        foreach ($auxJornadas as $jornada) {

            $cont = 0;
            $existe = false;
            while ($cont < count($this->operarios) && $existe == false) {

                if ($this->operarios[$cont]->getId() == $jornada->getOperario()) {
                    $this->operarios[$cont]->setJornadas($jornada);
                    $existe = true;
                }
                $cont++;
            }
        }
    }

    public function __toString() {
        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }

}
