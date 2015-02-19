<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/sedes.class.php");
include_once("../../../clases/areas.class.php");

$objSedes = new Sedes;
$objAreas = new Areas;

$nombre = $_POST['nombre'];
$descrip = $_POST['descrip'];
$cantidad = $_POST['cantidad'];

$areas = array();

$objAreas->get_areas($_SESSION['cliente']);
if($objAreas->has_value){
    foreach($objAreas->array_areas as $row){
        $areas[] = "'{$row['AR_ID']}'";
    }
}

if($objSedes->crear_sede($nombre, $descrip, $_SESSION['cliente'], $cantidad, $areas)){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>