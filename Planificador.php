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
        $this->pendientes = Array();
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
            // echo $jor->getMinutosLibres() . " minutos libres / despl " . $dist . "/ dur ".$current->getTotal()." /tareaId " . $current->getId() . " TOTAL ".$total."<br>";
            if ($jor->getMinutosLibres() >= $total) {
                // echo "asigno ".$current->getId()."<br>";
                $horainicio = $this->sumarHora($lastfin, $dist);
                $horafin = $this->sumarHora($horainicio, $current->getTotal());
                $current->setHoraInicio($horainicio);
                $current->setHoraFin($horafin);
                $indices = array_keys($totaltareas);
                $jor->addTarea($current, $total);
                unset($totaltareas[$indices[$auxtarea]]);
                $auxtarea++;
            } else {
                array_push($this->pendientes, $current);
                $auxtarea++;
            }
            if ($auxtarea == $nummenos) {
                // echo "nuevajornda";
                $auxjornada++;
                $auxtarea = 0;
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
        //devuelve las que no se han podido asignar
        return $this->pendientes;
    }

    function cancelarTarea($jornada, $tarea) {
        $i = array_search($tarea->getId(), array_keys($jornada));
        $keys = array_keys($jornada);
        $idlast = $keys[$i - 1];
        $total = $this->distanciaEntreDos($tarea->getId(), $idlast);
        $jornada->cancelarTarea($tarea, $total);
    }

    function reasignarTarea($jornada, $tarea) {
        //Comprobamos si el mismo operario tiene tiempo para ir al final
        $asignada = false;
        $last = $jornada->getLast();
        $dist = $this->distanciaEntreDos($tarea, $last);
        $total = $tarea->getTotal() + $dist;
        echo "total " . $total . " min libres " . $jornada->getMinutosLibres() . "<br>";
        if ($jornada->getMinutosLibres() >= $total) {
            $jornada->removeTarea($tarea);
            $jornada->addTarea($tarea, $total);
            $asignada = true;
            // Si no puede el mismo, vemos si otro puede.
        } else {
            $jornada->removeTarea($tarea);
            $fecha = $tarea->getFecha();
            $jornadas = Array();
            foreach ($this->operarios as $operario) {
                $aux = $operario->getJornadaDia($fecha);
                if ($aux != $jornada && $aux != null) {
                    array_push($jornadas, $aux);
                }
            }
            usort($jornadas, function($a, $b) use ($tarea) {
                $valorA = $a->getMinutosLibres() - $this->distanciaEntreDos($a->getLast(), $tarea);
                $valorB = $b->getMinutosLibres() - $this->distanciaEntreDos($b->getLast(), $tarea);
                if ($valorA == $valorB) {
                    return 0;
                }
                return ($valorB > $valorA) ? -1 : 1;
            });
            for ($i = 0; $i < count($jornadas) && $asignada == false; $i++) {
                $last = $jornadas[$i]->getLast();
                $total = $this->distanciaEntreDos($jornadas[$i]->getLast(), $tarea) + $tarea->getTotal();
                echo "tarda " . $this->distanciaEntreDos($jornadas[$i]->getLast(), $tarea) . "<br>";
                echo "dura " . $tarea->getTotal() . "<br>";
                echo $jornadas[$i]->getMinutosLibres() . " min libres " . $total . " total<br>";
                if ($jornadas[$i]->getMinutosLibres() >= $total) {
                    $jornadas[$i]->addTarea($tarea, $total);
                    $asignada = true;
                    echo "reasignada";
                }
            }
        }
        if(!$asignada){
            array_push($this->pendientes,$tarea);
        }
        return $asignada;
    }

    function sumarHora($hora, $minutos) {
        //// echo "hora inicio " . $hora . "  minutos " . $minutos . "<br>";
        $fecha = strtotime($hora) + ($minutos * 60);
        // echo "fecha ".  date('r', $fecha)."<br>";
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
