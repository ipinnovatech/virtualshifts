<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/imagenes.class.php");

$objImagenes = new Imagenes;

$id = $_POST['id_imagen'];

if($objImagenes->activar_imagen($id, $_POST['accion'])){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>