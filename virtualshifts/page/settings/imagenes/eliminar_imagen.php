<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/imagenes.class.php");

$objImagenes = new Imagenes;

$id = $_POST['id'];
$url = $_POST['url'];

if($objImagenes->eliminar_imagen($id)){
    $url = str_replace('http://184.168.29.222','/var/www/html', $url);
    unlink($url);
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>