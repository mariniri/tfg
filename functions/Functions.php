<?php

set_time_limit(0);
ini_set("memory_limit", "256M");
ini_set("auto_detect_line_endings", true);
// PHP configuration
// Define start time for duration calculation
define("TIME_START", microtime(true));

// Show debug information
define("DEBUG", false);

// Values for genetic algorithms
define("GA_CITY", 100);
define("GA_POPULATION", round(abs(log(GA_CITY + 1)) * 1000));
define("GA_SELECTION", 0.50);
define("GA_MUTATION", 0.1);
define("GA_CROSSOVER", 0.4);
srand();

class Functions {
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
    function __construct() {
        
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
            $minutos = ($horas * 60 + $aux[1]) * 60;
        } else {
            $aux = explode(" ", $tiempollegada);
            $minutos = $aux[0] * 60;
        }
        return $minutos;
    }

    function obtenerObjeto($objeto) {
        $propiedades = Array();
        foreach (get_object_vars($objeto) as $prop => $val) {
            $propiedades["$prop"] = $val;
        }
        return $propiedades;
    }

    function cancelaVisita($numOperarios, $operario, $visita) {
//$auxoperario = $this->obtenerObjeto($operario);
//$auxvisita = $this->obtenerObjeto($visita);
        if ($numOperarios < 2) {
            echo "No puede reasignarse la cita. Se programará para mañana";
            $this->reasignarCitaDiaSiguiente($operario, call_user_func(array($operario, 'getItinerarioDia'), $visita->getFecha()), $visita);
        }
    }

    function reasignarCitaDiaSiguiente($operario, $itinerario, $visita) {
        $auxvisita = $this->obtenerObjeto($visita);
        $aux = date_create($visita->getFecha());
        $aux->add(new DateInterval('P1D'));
        $aux = date_format($aux, 'y-m-d');
        call_user_func(array($visita, 'setFecha'), $aux);
        call_user_func(array($itinerario, 'eliminarVisita'), $visita);
        $itinerarioaux = call_user_func(array($operario, 'getItinerarioDia'), $aux);
        if ($itinerarioaux == null) {
            $itinerario = new Itinerario($aux, 480);
            $itinerario->anadirVisita($visita);
            call_user_func(array($operario, 'setItinerarioDia'), $itinerario, $aux);
        } else {
            call_user_func(array($itinerarioaux, 'anadirVisita'), $visita);
        }
        echo "Visita reasignada";
    }

    function runAlgorithm($visitas) {
        $maximumTime = 90;
        $currentGeneration = 0;

// Execution time of each generation
        $executionTime = array();

// Save best solutions in each loop
        $bestSolutionList = array();

        $manager = Manager::getInstance();
        $manager->load($visitas);
        $population = new Population();
        $distance = $this->getMatrizDistancia($visitas);
        $population->initialization(GA_POPULATION, $distance);
        if (DEBUG)
            echo 'initialization <br />';

        do {
            $population->selectionElitist(GA_SELECTION);
            if (DEBUG) {
                echo 'selectionElitist <br />';
            }
            if (DEBUG) {
                echo 'size : ' . $population->getSize() . ' <br />';
            }

            $population->mutationAll(GA_MUTATION);
            if (DEBUG) {
                echo 'mutationAll <br />';
            }
            if (DEBUG) {
                echo 'size : ' . $population->getSize() . ' <br />';
            }

            $population->crossoverAll(GA_CROSSOVER);
            if (DEBUG) {
                echo 'crossoverAll <br />';
            }
            if (DEBUG) {
                echo 'size : ' . $population->getSize() . ' <br />';
            }

            $currentTime = microtime(true) - TIME_START;

            $executionTime[$currentGeneration] = round($currentTime);
            $bestSolutionList[$currentGeneration] = $population->bestSolution();

            if (DEBUG) {
                echo '<p> (' . $currentTime . ' sec) ' . $bestSolutionList[$currentGeneration] . '</p>';
            }

            $currentGeneration++;
        }
        while ($currentTime < $maximumTime OR ( $maximumTime == null AND $population->isStagnant(0.01)));

//        echo "<pre>";
//        var_dump($this->getMatrizDistancia($visitas));
//        echo "</pre>";
    }

    function getMatrizDistancia($visitas) {
        $i = 0;
        $j = 0;
        $matriz = Array();
        for ($i = 0; $i < count($visitas); $i++) {
            for ($j = $i; $j < count($visitas); $j++) {
                if ($i == $j) {
                    $matriz[$i][$j] = 0;
                } else {
                    $aux = $this->getTiempoCocheDos($visitas[$i], $visitas[$j]);
                    $matriz[$i][$j] = $aux;
                    $matriz[$j][$i] = $aux;
                }
            }
        }
        return $matriz;
    }

}
