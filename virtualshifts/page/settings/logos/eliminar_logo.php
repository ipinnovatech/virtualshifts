<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/logos.class.php");

$objLogos = new Logos;

$id = $_POST['id'];
$url = $_POST['url'];

if($objLogos->eliminar_logo($id)){
    $url = str_replace('http://184.168.29.222','/var/www/html', $url);
    unlink($url);
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>