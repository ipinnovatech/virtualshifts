<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/imagenes.class.php");

$objImagenes = new Imagenes;

$id = $_POST['id_imagen'];
$descrip = $_POST['descrip'];

if($objImagenes->actualizar_imagen($id, $descrip)){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>