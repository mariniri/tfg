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

        $jornadas = Array();

        foreach ($this->operarios as $operario) {

            if (($aux = $operario->getJornadaDia($fecha))) {
                array_push($jornadas, $aux);
            }
        }
        $totaltareas = $this->tareas;
        $numtareas = count($totaltareas);
        $numjornadas = count($jornadas);
        $auxjornada = 0;
        $auxtarea = 0;
        while ($auxtarea < $numtareas && $auxjornada < $numjornadas) {
            $indices = array_keys($totaltareas);
            $nummenos = $numtareas - 1;
            $dist = 0;
            $jor = $jornadas[$auxjornada];
            $auxnum = $jor->numTareas();
            $current = $totaltareas[$indices[$auxtarea]];
            if ($auxnum > 0) {
                $last = $jor->getLast();
                $dist = $this->distanciaEntreDos($current, $last);
                $total = $dist + $current->getTotal();
                $lastfin = $last->getHoraFin();
            } else {
                $dist = $current->getDistanciaCentralDos($this->central);
                $total = $dist + $current->getTotal();
                $lastfin = $jor->getHoraInicio();
            }
            echo $jor->getMinutosLibres() . " inutos libres y necesitas " . $total . " para tareaId" . $current->getId() . "<br>";
            if ($jor->getMinutosLibres() >= $total) {

                $horainicio = $this->sumarHora($lastfin, $dist);
                $horafin = $this->sumarHora($horainicio, $current->getTotal());
                $current->setHoraInicio($horainicio);
                $indices = array_keys($totaltareas);
                $jor->addTarea($current);
                $auxid = $current->getId();
                unset($totaltareas[$auxid]);
                $auxtarea++;
            } else {
                $auxtarea++;
            }
            if ($auxtarea == $nummenos) {
                echo "nuevajornda";
                $auxjornada++;
                $auxtarea = 0;
                echo count($totaltareas);
            }


            $numtareas = count($totaltareas);
        }
        foreach ($this->operarios as $o) {
            foreach ($jornadas as $j) {
                if ($o->getId() == $j->getOperario()) {
                    $o->addJornada($j);
                }
            }
        }
    }

    function sumarHora($hora, $minutos) {
        $fecha = strtotime($hora) + ($minutos * 60);
        return date('r', $fecha);
    }

    public function __toString() {
        $cad = "<pre>";
        $cad .= print_r($this, true);
        $cad .= "</pre>";

        return $cad;
    }

    function distanciaEntreDos($tarea1, $tarea2) {
        $id1 = $tarea1->getId();
        $id2 = $tarea2->getId();
        $dist = $this->matrix["$id1"]["$id2"];
        return $dist;
    }

}
