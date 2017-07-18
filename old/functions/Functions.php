<?php

class Functions {

    public $visitas;
    public $operarios;
    public $central;

    /*
     * Maximum execution time
     * -> null if calculate until stagnation is detected
     * -> otherwise calculate until maximumTime is reached
     */

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    /**
     * Description of Functions
     *
     * @author marina
     */
    function __construct($v, $o, $c) {
        $this->central = $c;
        $this->operarios = $o;
        $this->central = $c;
    }

    function getVisitas() {
        return $this->visitas;
    }

    function getOperarios() {
        return $this->operarios;
    }

    function getCentral() {
        return $this->central;
    }

    function setVisitas($visitas) {
        $this->visitas = $visitas;
    }

    function setOperarios($operarios) {
        $this->operarios = $operarios;
    }

    function setCentral($central) {
        $this->central = $central;
    }

        
    function getTiempoCoche($lat1, $lat2, $long1, $long2) {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=es-ES";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        if ($response_a['rows'][0]['elements'][0]['status'] == "ZERO_RESULTS") {
            return "UNREACHABLE";
        } else {
            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
            $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
            return array('distance' => $dist, 'time' => $time);
        }
    }

    function getTiempoCocheDos($visita1, $visita2) {
        $lat1 = $visita1->getLatitud();
        $long1 = $visita1->getLongitud();
        $lat2 = $visita2->getLatitud();
        $long2 = $visita2->getLongitud();

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=es-ES";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        if ($response_a['rows'][0]['elements'][0]['status'] == "ZERO_RESULTS") {
            return "UNREACHABLE";
        } else {
            $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
            $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
            return $this->getSegundos($time);
        }
    }

    function llegaCita($horacita, $tiempollegada) {
        $minutos = $this->getSegundos($tiempollegada);
        $horaactual = date('H:i');
        $horallegada = date("H:i", strtotime($horaactual) + $minutos);
        echo $horallegada;
        if (strtotime($horallegada) >= strtotime($horacita)) {
            echo true;
        } else {
            echo false;
        }
    }

    function getSegundos($tiempollegada) {
        if (strpos($tiempollegada, 'h')) {
            $aux = explode("h", $tiempollegada);
            $horas = $aux[0];
            $aux = explode(" ", $tiempollegada);
            $minutos = ($horas * 60 + $aux[1]);
        } else {
            $aux = explode(" ", $tiempollegada);
            $minutos = $aux[0];
        }
        return $minutos;
    }

//    function obtenerObjeto($objeto) {
//        $propiedades = Array();
//        foreach (get_object_vars($objeto) as $prop => $val) {
//            $propiedades["$prop"] = $val;
//        }
//        return $propiedades;
//    }
//
//
//
//    function reasignarCitaDiaSiguiente($operario, $itinerario, $visita) {
//        $auxvisita = $this->obtenerObjeto($visita);
//        $aux = date_create($visita->getFecha());
//        $aux->add(new DateInterval('P1D'));
//        $aux = date_format($aux, 'y-m-d');
//        call_user_func(array($visita, 'setFecha'), $aux);
//        call_user_func(array($itinerario, 'eliminarVisita'), $visita);
//        $itinerarioaux = call_user_func(array($operario, 'getItinerarioDia'), $aux);
//        if ($itinerarioaux == null) {
//            $itinerario = new Itinerario($aux, 480);
//            $itinerario->anadirVisita($visita);
//            call_user_func(array($operario, 'setItinerarioDia'), $itinerario, $aux);
//        } else {
//            call_user_func(array($itinerarioaux, 'anadirVisita'), $visita);
//        }
//        echo "Visita reasignada";
//    }

    function runAlgorithm($visitas, $operarios) {

//        $plan = new Plan();
//        foreach ($visitas as $v) {
//            $plan->addPlace($v);
//        }
//
//        $life = new Life();
//        $matriz = $life->getRoadmap()->getMatrix();

        $salida = new Visita("2017-01-01 8:30", "2017-01-01 09:00", "37.3437043", "-5.938952", "Central LIDL");
        $preordenadas = $this->preordenar($visitas, $salida);
        $this->distribuir($preordenadas, $operarios);

        foreach ($operarios as $o) {
            echo "<pre>";
            var_dump($o->getJornada());
            echo "</pre>";
        }
//        
////  
//        $roadmap = $life->getShortestPath($plan);
//
//        echo "Distance: {$roadmap->distance()} \n";
//        foreach ($roadmap->places as $place) {
//            echo "Move: {$place->getDireccion()} \n";
//        }
//
//        $this->asignarItinerario($roadmap, 400, 2);
    }

    function distribuir($visitas, $operarios) {
//        $asignada = false;
//        for ($i = 0; $i < count($visitas); $i++) {
//            $v = $visitas[$i][1];
//            $fecha = $v->getFecha();
//            echo $fecha . "<br>";
//            $asignada = false;
//            for ($j = 0; $j < count($operarios) && $asignada == false; $j++) {
//                $operaux = $operarios[$j];
//                $jornaux = $operaux->getJornadaDia($fecha);
//                if ($jornaux) {
//                    if ($jornaux->comprobarDisponibilidad($v)) {
//                        $jornaux->agregarTarea($v);
//                        $asignada = true;
//                    }
//                }
//            }
//        }
    }

    function preordenar($visitas, $central) {
        $preordenado = Array();
        foreach ($visitas as $v) {
            $aux = Array();
            $dist = $this->distanciaEuclidea($v, $central);
            array_push($aux, $dist);
            array_push($aux, $v);
            array_push($preordenado, $aux);
        }

        usort($preordenado, function($a, $b) {
            return $a[0] <=> $b[0];
        });
        return $preordenado;
    }

    function distanciaEuclidea($lugar1, $lugar2) {
        $latitud1 = floatval($lugar1->getLatitud());
        $latitud2 = floatval($lugar2->getLatitud());
        $longitud1 = floatval($lugar1->getLongitud());
        $longitud2 = floatval($lugar2->getLongitud());
        $degrees = rad2deg(acos((sin(deg2rad($latitud1)) * sin(deg2rad($latitud2))) + (cos(deg2rad($latitud1)) * cos(deg2rad($latitud2)) * cos(deg2rad($longitud1 - $longitud2)))));
        $distancia = $degrees * 111.13384;
        return $distancia;
    }

//
//    function asignarItinerario($roadmap, $tiempomaximo, $maxoperarios, $prioridaad) {
//        $tiempototal = $roadmap->getTiempototal();
//        $operarios = round($tiempototal / $tiempomaximo, 0, PHP_ROUND_HALF_UP);
}
