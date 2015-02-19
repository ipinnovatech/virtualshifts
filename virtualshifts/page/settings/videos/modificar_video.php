<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/videos.class.php");

$objVideos = new Videos;

$id = $_POST['id_video'];
$descrip = $_POST['descrip'];

if($objVideos->actualizar_video($id, $descrip)){
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>