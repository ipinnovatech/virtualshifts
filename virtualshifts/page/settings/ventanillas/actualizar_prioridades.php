<?php
ini_set("display_errors",1);

include_once("../../../clases/ventanillas_areas.class.php");

$objVentanillasAreas = new VentanillasAreas;

$ventanilla = $_POST['ventanilla_prioridad'];
$prioridades = $_POST['prioridades'];

foreach($prioridades as $key => $prioridad){
    if($objVentanillasAreas->actualiza_prioridad_por_ventanilla_y_area($ventanilla, $key, $prioridad)){
        $status = "success";
    }else{
        $status = "error";
    }
}

echo $status;
?>