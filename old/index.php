<?php

//include 'classes/Usuario.php';


include_once 'classes/Operario.php';
include_once 'classes/Visita.php';
include_once 'classes/Jornada.php';
include_once 'classes/GeneticAlgorithm2/Distance.php';
include_once 'classes/GeneticAlgorithm2/Life.php';
include_once 'classes/GeneticAlgorithm2/Place.php';
include_once 'classes/GeneticAlgorithm2/Plan.php';
include_once 'classes/GeneticAlgorithm2/Point.php';
include_once 'classes/GeneticAlgorithm2/Roadmap.php';
include_once 'classes/GeneticAlgorithm2/Selection.php';
include 'functions/Functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Madrid');
$formato = 'H:i';
$horainicio = '2017-01-02 11:00';
$horafin = '2017-01-02 11:20';
$horainicio2 = '2017-01-01 15:16';
$horafin2 = '2017-01-01 17:11';
$horainicio3 = '2017-01-01 16:17';
$horafin3 = '2017-01-01 17:00';
$horainicio4 = '2017-01-01 09:00';
$horafin4 = '2017-01-01 09:32';
$horainicio5 = '2017-01-01 11:00';
$horafin5 = '2017-01-01 11:20';
$horainicio6 = '2017-01-01 15:16';
$horafin6 = '2017-01-01 17:11';
$horainicio7 = '2017-01-01 16:17';
$horafin7 = '2017-01-01 17:00';
$horainicio8 = '2017-01-01 09:00';
$horafin8 = '2017-01-01 09:32';

$latitud = "37.3414513";
$longitud = "-5.9342479";
$latitud2 = "37.3533261";
$longitud2 = "-5.9441381";
$latitud3 = "37.3654316";
$longitud3 = "-5.9675879";
$latitud4 = "37.389767";
$longitud4 = "-6.0388054";
$direccion = "Colegio Gloria Fuertes";
$direccion2 = "UPO";
$direccion3 = "Alcampo";
$direccion4 = "Isla mágica";

$visita = new Visita($horainicio, $horafin, $latitud, $longitud, $direccion);
$visita->setIdvisita("a");
$visita->setPosicion(0);
$visita2 = new Visita($horainicio2, $horafin2, $latitud2, $longitud2, $direccion2);
$visita2->setIdvisita("b");
$visita2->setPosicion(1);
$visita3 = new Visita($horainicio3, $horafin3, $latitud3, $longitud3, $direccion3);
$visita3->setIdvisita("c");
$visita3->setPosicion(2);
$visita4 = new Visita($horainicio4, $horafin4, $latitud4, $longitud4, $direccion4);
$visita4->setIdvisita("d");
$visita4->setPosicion(3);
$visita5 = new Visita($horainicio4, $horafin4, "37.3543942", "-5.9599113", "Brico Depot");
$visita5->setIdvisita("e");
$visita5->setPosicion(4);
$visita6 = new Visita($horainicio4, $horafin4, "37.3839305", "-6.0039425", "Plaza de armas");
$visita6->setIdvisita("f");
$visita6->setPosicion(5);
$visita7 = new Visita($horainicio4, $horafin4, "37.3850217", "-5.9957027", "La Macarena");
$visita7->setIdvisita("g");
$visita7->setPosicion(6);
$visita8 = new Visita($horainicio4, $horafin4, "37.2853683", "-5.9333897", "Dos hermanas");
$visita8->setIdvisita("h");
$visita8->setPosicion(7);

$visitas = array($visita, $visita2, $visita3, $visita4, $visita5, $visita6, $visita7, $visita8);
$functions = new Functions();

$jornada1 = new Jornada("2017-01-02 09:00", "2017-01-02 17:00", 1);
$jornada2 = new Jornada("2017-01-01 09:00", "2017-01-01 16:00", 2);
$jornada3 = new Jornada("2017-01-01 15:00", "2017-01-01 19:00", 3);

$operario1 = new Operario(null, 1, null);
$operario2 = new Operario(null, 2, null);
$operario3 = new Operario(null, 3, null);
$operario1->addJornada($jornada1);
$operario2->addJornada($jornada2);
$operario3->addJornada($jornada3);

$operarios = Array();
array_push($operarios, $operario1);
array_push($operarios, $operario2);
array_push($operarios, $operario3);


$functions->runAlgorithm($visitas, $operarios);
//$functions->cancelaVisita(1, $operario, $visita)
?>