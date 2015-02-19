<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/ventanillas.class.php");

$objVentanillas = new Ventanillas;

$nombre = $_POST['nombre'];
$descrip = $_POST['descrip'];
$id = $_POST['id_ventanilla'];

if($objVentanillas->actualizar_ventanilla($id, $nombre, $descrip)){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>