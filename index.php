<?php

//include 'classes/Usuario.php';
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

include 'classes/Operario.php';
include 'classes/Visita.php';
include 'classes/Itinerario.php';
include 'classes/GeneticAlgorithm/Manager.php';
include 'classes/GeneticAlgorithm/Population.php';
include 'classes/GeneticAlgorithm/Solution.php';

include 'functions/Functions.php';

date_default_timezone_set('Europe/Madrid');
$formato = 'H:i';
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
$latitud2 = "37.3533261";
$longitud2 = "-5.9441381,17";
$latitud3 = "37.3654316";
$longitud3 = "-5.9675879";
$latitud4 = "37.389767";
$longitud4 = "-6.0388054";
$direccion = "Colegio Gloria Fuertes";
$direccion2 = "UPO";
$direccion3 = "Alcampo";
$direccion4 = "Isla mágica";

$latitud2 = "37.9487253";
$longitud2 = "-6.154024100000015";
$visita = new Visita(date("y-m-d"), $horainicio, $horafin, $latitud, $longitud, $direccion, 25);
$visita->setIdvisita("a");
$visita->setPosicion(0);
$visita2 = new Visita(date("y-m-d"), $horainicio2, $horafin2, $latitud2, $longitud2, $direccion2, 110);
$visita2->setIdvisita("b");
$visita2->setPosicion(1);
$visita3 = new Visita(date("y-m-d"), $horainicio3, $horafin3, $latitud3, $longitud3, $direccion3, 32);
$visita3->setIdvisita("c");
$visita3->setPosicion(2);
$visita4 = new Visita(date("y-m-d"), $horainicio4, $horafin4, $latitud4, $longitud4, $direccion4, 99);
$visita4->setIdvisita("d");
$visita4->setPosicion(3);

$visitas = array($visita, $visita2, $visita3, $visita4);
$functions = new Functions();

$itinerario = new Itinerario(date("y-m-d"), 480);
$itinerario->anadirVisita($visita);
$itinerario->anadirVisita($visita2);
$operario = new Operario("null", "null", 1, "null");
$operario->setItinerarioDia($itinerario, date("y-m-d"));
$functions->runAlgorithm($visitas);
//$functions->cancelaVisita(1, $operario, $visita)
?>