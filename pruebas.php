<?php

$tareas = array("t0" => 123, "t1" => 1203, "t2" => 23, "t3" => 13, "t3" => 230, "t4" => 1273, "t5" => 923, "t6" => 723, "t7" => 1273, "t8" => 923, "t9" => 723);
$operarios = array(array(), array(), array());
$limitTareasOperarios = 4;
$limitOperarios = 2;
//function intercambiar(&$array, $origen, $destino) {
//    $indices = array_keys($array);
//    $aux = $tareas[$indices[$destino]];
//    $tareas[$indices[$origen]] = $aux;
//}

function operarTareas($tareas, &$operarios, $limitTareasOperarios,$limitOperarios) {

    $tamTareas = count($tareas);
    $cont = 0;
    $actualOper = 0;
    while ($tamTareas>0 && $actualOper<$limitOperarios) {

        if (count($operarios[$actualOper]) < $limitTareasOperarios) {

            $indices = array_keys($tareas);
            $operarios[$actualOper][] = $tareas[$indices[0]];
            $aux = $tareas[$indices[$tamTareas - 1]];
            $tareas[$indices[0]] = $aux;
          
            array_pop($tareas);
           
          

            echo "<pre>";

            print_r($tareas);

            echo "</pre>";
        }

        if (count($operarios[$actualOper]) == $limitTareasOperarios) {

            $actualOper = $actualOper + 1;
           
        }
        
         $tamTareas = count($tareas);
    }
}

operarTareas($tareas, $operarios, $limitTareasOperarios, $limitOperarios);


echo "<pre>";

print_r($tareas);
print_r($operarios);
echo "</pre>";
?>
