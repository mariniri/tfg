<?php

//include 'classes/Usuario.php';
    

include_once 'classes/Operario.php';
include_once 'classes/Visita.php';
include_once 'classes/Itinerario.php';
include_once 'classes/GeneticAlgorithm2/Distance.php';
include_once 'classes/GeneticAlgorithm2/Life.php';
include_once 'classes/GeneticAlgorithm2/Place.php';
include_once 'classes/GeneticAlgorithm2/Plan.php';
include_once 'classes/GeneticAlgorithm2/Point.php';
include_once 'classes/GeneticAlgorithm2/Roadmap.php';
include_once 'classes/GeneticAlgorithm2/Selection.php';
include 'functions/Functions.php';

date_default_timezone_set('Europe/Madrid');
$formato='H:i';
$horainicio = date('H:i');
$horafin = date('H:i');
$horainicio2 = date('15:16');
$horafin2 = date('17:11');
$horainicio3 = date('16:17');
$horafin3 = date('17:00');
$horainicio4 = date('09:00');
$horafin4 = date('09:32');

$latitud = "37.3414513704974";
$longitud = "-5.934247970581055";
$latitud2="37.3533261";
$longitud2="-5.9441381,17";
$latitud3="37.3654316";
$longitud3="-5.9675879";
$latitud4="37.389767";
$longitud4="-6.0388054";
$direccion = "Colegio Gloria Fuertes";
$direccion2 = "UPO";
$direccion3 = "Alcampo";
$direccion4 = "Isla mágica";

$latitud2 = "37.9487253";
$longitud2 = "-6.154024100000015";
$visita = new Visita(date("y-m-d"),$horainicio, $horafin, $latitud, $longitud, $direccion,25);
$visita->setIdvisita("a");
$visita->setPosicion(0);
$visita2 = new Visita(date("y-m-d"),$horainicio2, $horafin2, $latitud2, $longitud2, $direccion2,110);
$visita2->setIdvisita("b");
$visita2->setPosicion(1);
$visita3 = new Visita(date("y-m-d"),$horainicio3, $horafin3, $latitud3, $longitud3, $direccion3,32);
$visita3->setIdvisita("c");
$visita3->setPosicion(2);
$visita4 = new Visita(date("y-m-d"),$horainicio4, $horafin4, $latitud4, $longitud4, $direccion4,99);
$visita4->setIdvisita("d");
$visita4->setPosicion(3);
$visita5=new Visita(date("y-m-d"),null,null,"37.3543942","-5.9599113","Brico Depot",22);
$visita5->setIdvisita("e");
$visita5->setPosicion(4);
$visita6=new Visita(date("y-m-d"),null,null,"37.3839305","-6.0039425","Plaza de armas",72);
$visita6->setIdvisita("f");
$visita6->setPosicion(5);
$visita7=new Visita(date("y-m-d"),null,null,"37.3850217","-5.9957027","La Macarena",5);
$visita7->setIdvisita("g");
$visita7->setPosicion(6);
$visita8=new Visita(date("y-m-d"),null,null,"37.2853683","-5.9333897","Dos hermanas",22);
$visita8->setIdvisita("h");
$visita8->setPosicion(7);
$visitas=array ($visita,$visita2,$visita3,$visita4,$visita5,$visita6,$visita7,$visita8);
$functions = new Functions();

$itinerario = new Itinerario(date("y-m-d"), 480);
$itinerario->anadirVisita($visita);
$itinerario->anadirVisita($visita2);
$operario = new Operario("null", "null", 1, "null");
$operario->setItinerarioDia($itinerario, date("y-m-d"));
$functions->runAlgorithm($visitas);
//$functions->cancelaVisita(1, $operario, $visita)
?>