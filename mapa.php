<?php

require('GoogleMapAPIv3.class.php');
$gmap = new GoogleMapAPI();
$gmap->setDivId('test1');
$gmap->setDirectionDivId('route');
$gmap->setCenter('Sevilla Spain');
$gmap->setEnableWindowZoom(true);
$gmap->setEnableAutomaticCenterZoom(false);
$gmap->setDisplayDirectionFields(true);
$gmap->setClusterer(true);
$gmap->setSize('600px','600px');
$gmap->setZoom(11);
$gmap->setLang('es');
$gmap->setDefaultHideMarker(false);
// $gmap->addDirection('nantes','paris');


$coordtab = array();
$coordtab []= array('37.355241', '-5.937404','test','<strong>test upo</strong>');
$gmap->addArrayMarkerByCoords($coordtab,'tareas');
$gmap->generate();
echo $gmap->getGoogleMap();

?>

