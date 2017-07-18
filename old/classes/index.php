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
    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Europe/Madrid");
        include_once 'Tareas.php';
        include_once 'Jornada.php';


        $tarea0 = new Tareas('2017-01-01 9:45', '2017-01-01 10:46');
        $tarea1 = new Tareas('2017-01-01 10:50', '2017-01-01 14:45');
        $tarea2 = new Tareas('2017-01-01 15:50', '2017-01-01 16:00');


        $jornada = new Jornada('2017-01-01 9:30', '2017-01-01 18:30');



        echo $e = $jornada->agregarTarea($tarea2);
        echo $s = $jornada->agregarTarea($tarea1);
        echo $x = $jornada->agregarTarea($tarea0);


        echo $jornada;
        ?>
    </body>
</html>
