<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/videos.class.php");

$objVideos = new Videos;

$id = $_POST['id_video'];
$url = $_POST['url'];

if($objVideos->eliminar_video($id)){
    $url = str_replace('http://184.168.29.222','/var/www/html', $url);
    unlink($url);
    echo "success";
    exit;
}else{    
    echo "error";
    exit;   
}
?>