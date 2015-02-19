<?php
ini_set("display_errors", 1);
session_start();
include_once("../../../clases/auxiliaries.class.php");

$objAuxiliaries = new Auxiliaries;

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$duracion = $_POST['duracion'];
$cliente = $_SESSION['cliente'];
$id_auxiliary=$_POST['auxiliary_id'];

if($objAuxiliaries->update_auxiliary($id_auxiliary, $nombre, $descripcion, $duracion, $cliente)){
    echo "success"; 
}else{
    echo "error";
}
?>