<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/ventanillas_areas.class.php");

$objVentanillasAreas = new VentanillasAreas;

$ventanilla = $_POST['ventanilla'];
$areas = isset($_POST['areas'])?$_POST['areas']:array();

$objVentanillasAreas->delete_areas_por_ventanilla($ventanilla);

if(count($areas)>0){
    if($objVentanillasAreas->agregar_areas_por_ventanilla($ventanilla,$areas)){
        echo "success";
        exit;
    }else{
        echo "error";
        exit;
    }
}else{
    echo "success";
    exit;
}

?>