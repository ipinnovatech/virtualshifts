<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/auxiliaries.class.php");

$objAuxiliaries = new Auxiliaries;

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$duracion = $_POST['duracion'];
$objAuxiliaries->get_aux_nombre($nombre);

if($objAuxiliaries->has_value){
    echo "existe";
}else{
    if($objAuxiliaries->crear_auxiliary($nombre,$descripcion,$duracion,$_SESSION['cliente'])){
       echo "success"; 
    }else{
        echo "error";
    }
}
?>