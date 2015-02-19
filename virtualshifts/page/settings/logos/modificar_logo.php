<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/logos.class.php");

$objLogos = new Logos;

$id = $_POST['logo_id'];
$descrip = $_POST['descripcion'];

if($objLogos->update_logo($id, $descrip)){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>