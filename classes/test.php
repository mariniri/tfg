

<?php
include_once 'Visita.php';

date_default_timezone_set('Europe/Madrid');

$horainicio = date('H:i');
$horafin = date('H:i');
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
$visita = new Visitas(date("y-m-d"),$horainicio, $horafin, $latitud, $longitud, $direccion);
$visita->setIdvisita(0);
$visita2 = new Visitas(date("y-m-d"),$horainicio, $horafin, $latitud2, $longitud2, $direccion2);
$visita->setIdvisita(2);
$visita3 = new Visitas(date("y-m-d"),$horainicio, $horafin, $latitud3, $longitud3, $direccion3);
$visita->setIdvisita(3);
$visita4 = new Visitas(date("y-m-d"),$horainicio, $horafin, $latitud4, $longitud4, $direccion4);
$visita->setIdvisita(4);

$visitas=array ($visita,$visita2,$visita3,$visita4);

function recorrer(){
    
    $visitax = new Visitas(date("y-m-d"),"kk", "kk", "kk", "kk", "kk");
    $visitax->setIdvisita("puta");
    imprimir($visitax);
}

function imprimir($visitax){
    echo $visitax->getIdvisita();
}
recorrer();
?>

