<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/ventanillas.class.php");

$objVentanillas = new Ventanillas;

$nombre = $_POST['nombre'];
$descrip = $_POST['descrip'];
$sede = $_POST['sede'];

if($objVentanillas->crear_ventanilla($nombre, $descrip, $_SESSION['cliente'],$sede)){
    echo "success";
    exit;
}else{
    if($objVentanillas->insert_id == 0){
        echo "error";
        exit;
    }else{
        echo "error2";
        exit; 
    }    
}
?>