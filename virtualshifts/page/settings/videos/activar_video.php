<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/videos.class.php");

$objVideos = new Videos;

$id = $_POST['id_video'];

if($objVideos->activar_video($id, $_POST['accion'])){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>