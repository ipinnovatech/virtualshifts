<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/ventanillas.class.php");

$objVentanillas = new Ventanillas;

$id = $_POST['id_ventanilla'];

if($objVentanillas->activar_ventanilla($id, $_POST['accion'])){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>