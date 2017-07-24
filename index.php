<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            #map {
                height: 100%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>

    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('memory_limit', '512M');
        error_reporting(E_ALL);
        date_default_timezone_set("Europe/Madrid");

        include_once 'Tarea.php';
        include_once 'Jornada.php';
        include_once 'Operario.php';
        include_once 'Central.php';
        include_once 'Planificador.php';

//        include_once 'GeneticAlgorithm/Plan.php';
        include_once 'Distance.php';
//        include_once 'GeneticAlgorithm/Life.php';
//        include_once 'GeneticAlgorithm/Place.php';
//        include_once 'GeneticAlgorithm/Point.php';
//        include_once 'GeneticAlgorithm/Roadmap.php';
//        include_once 'GeneticAlgorithm/Selection.php';
        include_once 'GoogleMapAPIv3.class.php';

        $central = new Central("Universidad Pablo de Olavide", 37.355241, -5.937404, "Universidad Pablo de Olavide Spain");
        $tareas = Array();
        array_push($tareas, new Tarea('2017-01-01 8:30', '300', 37.337252, -5.931373, 1));
        array_push($tareas, new Tarea('2017-01-01 10:30', '300', 37.343170, -5.937070, 2));
        array_push($tareas, new Tarea('2017-01-01 10:00', '300', 37.352671, -5.947069, 3));
        array_push($tareas, new Tarea('2017-01-01 14:46', '30', 37.3590926, -5.74919037, 4));
        array_push($tareas, new Tarea('2017-01-01 15:46', '300', 37.51043415, -5.55282209, 5));
        array_push($tareas, new Tarea('2017-01-01 16:46', '300', 37.02648063, -6.17896675, 6));
        array_push($tareas, new Tarea('2017-01-01 11:46', '30', 37.6893324, -6.24471462, 7));
        array_push($tareas, new Tarea('2017-01-01 12:46', '300', 37.41053292, -6.23668757, 8));

//        array_push($tareas, new Tarea('2017-01-01 13:46', '2017-01-01 14:00', 37.40079571, -6.07446391));
//        array_push($tareas, new Tarea('2017-01-01 15:46', '2017-01-01 16:00', 37.47746476, -5.52077692));
//        array_push($tareas, new Tarea('2017-01-01 16:46', '2017-01-01 17:30', 37.36511825, -5.73941369));
//        array_push($tareas, new Tarea('2017-01-01 17:46', '2017-01-01 18:00', 37.55326254, -6.45127272));
//        array_push($tareas, new Tarea('2017-01-01 10:46', '2017-01-01 11:05', 37.72000248, -5.8170112));
//        array_push($tareas, new Tarea('2017-01-01 11:46', '2017-01-01 12:00', 37.76849962, -6.24883921));
//        array_push($tareas, new Tarea('2017-01-01 12:46', '2017-01-01 16:00', 37.27382539, -6.33956964));
//        array_push($tareas, new Tarea('2017-01-01 13:46', '2017-01-01 14:50', 37.44048757, -6.08649184));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.66329671, -6.19722272));
//        array_push($tareas, new Tarea('2017-01-01 15:46', '2017-01-01 18:00', 37.83041326, -6.03947849));
//        array_push($tareas, new Tarea('2017-01-01 16:46', '2017-01-01 16:50', 37.33642354, -6.27302163));
//        array_push($tareas, new Tarea('2017-01-01 17:46', '2017-01-01 18:00', 37.25872651, -6.09619711));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.11080882, -6.23839211));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.04770585, -5.83622671));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.50697084, -5.93377569));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.77229034, -5.8679861));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.44637021, -6.54452201));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.30277325, -5.71260069));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.14006767, -5.87072296));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.22081312, -5.64454292));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.04799197, -6.24980069));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.53510953, -6.48892391));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.08130307, -6.32861221));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.25062433, -6.31813223));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.32010379, -6.19139763));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.09036781, -6.36286103));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 36.98567106, -5.92692982));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.73685544, -6.28285979));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.34577813, -6.39194211));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.11261974, -6.16186259));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.43548363, -5.65762772));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.39048303, -6.50952182));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.35546706, -5.5115389));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.63483506, -5.55349572));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.27381154, -6.35931072));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.76849962, -6.24883921));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.27382539, -6.33956964));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.44048757, -6.08649184));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.66329671, -6.19722272));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.83041326, -6.03947849));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.33642354, -6.27302163));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.25872651, -6.09619711));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.11080882, -6.23839211));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.04770585, -5.83622671));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.50697084, -5.93377569));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.77229034, -5.8679861));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.44637021, -6.54452201));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.30277325, -5.71260069));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.14006767, -5.87072296));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.22081312, -5.64454292));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.04799197, -6.24980069));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.53510953, -6.48892391));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.08130307, -6.32861221));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.25062433, -6.31813223));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.32010379, -6.19139763));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.09036781, -6.36286103));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 36.98567106, -5.92692982));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.73685544, -6.28285979));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.34577813, -6.39194211));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.11261974, -6.16186259));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.43548363, -5.65762772));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.39048303, -6.50952182));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.35546706, -5.5115389));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.634835, -5.55349572));
//        array_push($tareas, new Tarea('2017-01-01 14:46', '2017-01-01 16:00', 37.27381154, -6.35931072));




        $operarios = Array();

        $oper1 = new Operario("11", "Antonio");
        $oper2 = new Operario("12", "Marina");
        $oper3 = new Operario("13", "Maria");

        $jornada1 = new Jornada('2017-01-01 9:30', '2017-01-01 18:30');
        $jornada2 = new Jornada('2017-01-01 9:30', '2017-01-01 18:30');
        $jornada3 = new Jornada('2017-01-01 9:30', '2017-01-01 18:30');




        $oper1->addJornada($jornada1);
        $oper2->addJornada($jornada2);
        $oper3->addJornada($jornada3);

        array_push($operarios, $oper1);
        array_push($operarios, $oper2);
        array_push($operarios, $oper3);


        $planificador = new Planificador($operarios, $tareas, $central);

//
//        echo '<pre>';
//       print_r($planificador);
//        echo 'Tareas Ordenadas desde central:<br>';
//      //   print_r($planificador->getTareas());

        $planificador->distribuirTareas("2017-01-01");
        //  echo "Operario con sus Tareas asignadas:<br>";
        //   print_r($planificador->getOperarios());
//        $plan = new Plan();
//        foreach ($tareas as $v) {
//            $plan->addPlace($v);
//        }
//
//
//
//        $life = new Life($plan->getPlaces(), null);
//        $matriz = $life->getRoadmap()->getMatrix();
//        // $roadmap = $life->getShortestPath($plan);
//
//        echo "<pre>";
//        var_dump($matriz);
//        echo "</pre>";
//        echo "Tareas pendientes:<br>";
//        //   print_r($planificador->getPendientes());
//        echo '</pre>';

        $gmap = new GoogleMapAPI();
        $gmap->setDivId('test1');
        $gmap->setDirectionDivId('route');
        $gmap->setCenter($central->getDireccion());
        $gmap->setCenterName($central->getNombre());

        $gmap->setEnableWindowZoom(true);
        $gmap->setEnableAutomaticCenterZoom(true);
        //$gmap->setDisplayDirectionFields(true);
        $gmap->setClusterer(true);
        $gmap->setSize('100%', '600px');
        $gmap->setZoom(11);
        $gmap->setLang('es');
        $gmap->setDefaultHideMarker(false);
// $gmap->addDirection('nantes','paris');


        $operariosTareas = $planificador->getOperarios();

        $colorsIcons = $gmap->getColorsIcon();



        $colors = 1;
        $cont = 1;

        foreach ($operariosTareas as $oper) {
            $nombre = $oper->getNombre();

            $jornadasOper = $oper->getJornadas();
            echo "<pre>";
            var_dump($jornadasOper);
            echo "</pre>";
            if ($cont == 1) {
                $gmap->addMarkerByCoords($central->getLatitud(), $central->getLongitud(), 'Central :' . $central->getNombre(), '<strong>Direccion: <br>' . $central->getDireccion() . '</strong>', '', $colorsIcons[0], 0, true, $central->getNombre());
            }
            foreach ($jornadasOper->getTareas() as $t) {

                if (count($t) > 0) {
                    $gmap->addMarkerByCoords($t->getLatitud(), $t->getLongitud(), 'Operario ' . $nombre, '<strong>Operario : '  .  '<br>Total Minutos: ' . ($t->getTotal() ) . '</strong>', '', $colorsIcons[$colors], $cont++, true, $nombre);
                }
            }
            $colors++;
        }

        $gmap->addPolyLines();

//        foreach ($planificador->getPendientes() as $t) {
//
//                //$coordtab [] = array($t->getLatitud(), $t->getLongitud(), 'Operario ' . $nombre, '<strong>Operario :' . $nombre . '<br>Inicio: ' . $t->getFechaInicio() . "<br>Fin: " . $t->getFechaFin() . '</strong>');
//
//                $gmap->addMarkerByCoords($t->getLatitud(), $t->getLongitud(), 'Pendiente', '<strong>Operario : <br>Inicio : ' . $t->getFechaInicio() . '<br>Fin : ' . $t->getFechaFin() . '<br>Total Minutos: ' . ($t->getTotal() / 60) . '</strong>', '', $colorsIcons[0], $cont++, true, 'Pendiente');
//            }
//        echo "<pre>";
//        echo count($planificador->getTareas());
//        print_r($gmap->getPath());
//        echo "</pre>";


        $gmap->generate();
        echo $gmap->getGoogleMap();
        ?>





    </body>

</html>
