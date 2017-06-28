<?php

class Distance {

    public static function between(Visita $visita1, Visita $visita2, $type) {
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
            if ($type == "time") {
                $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
                return Distance::getSegundos($time);
            } else {
                $dist=$response_a['rows'][0]['elements'][0]['distance']['text'];
                return Distance::getKm($dist);
            }
        }
    }
    
    function getKm($distance){
         $aux = explode(" ", $distance);
         $aux2= str_replace(",", ".", $aux[0]);
         return $aux2;
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

    public static function getTimeMatrix($visitas) {
           $matriz = Array();
        for ($i = 0; $i < count($visitas); $i++) {
            for ($j = $i; $j < count($visitas) ; $j++) {
                if ($j == $i) {
                    $matriz[$i][$j] = 0.0;
                } else {
                $aux = Distance::between($visitas[$i], $visitas[$j], "time");
                $matriz[$i][$j]= floatval($aux);
                $matriz[$j][$i]= floatval($aux);
                }
            }
            
        }
         
        return $matriz;
    }
    
    public static function getDistMatrix($visitas) {
        $matriz = Array();
        for ($i = 0; $i < count($visitas); $i++) {
            for ($j = $i; $j < count($visitas) ; $j++) {
                if ($j == $i) {
                    $matriz[$i][$j] = 0.0;
                } else {
                $aux = Distance::between($visitas[$i], $visitas[$j], "distance");
                $matriz[$i][$j]= floatval($aux);
                $matriz[$j][$i]= floatval($aux);
                }
            }
            
        }
         
        return $matriz;
    }

}
