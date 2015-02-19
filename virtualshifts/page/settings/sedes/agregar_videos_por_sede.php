<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/videos_sedes.class.php");

$objVideosSedes = new VideosSedes;

$sede = $_POST['sede'];
$videos = isset($_POST['videos'])?$_POST['videos']:array();

$objVideosSedes->delete_videos_por_sede($sede);

if(count($videos)>0){
    if($objVideosSedes->agregar_videos_por_sede($sede,$videos)){
        echo "success";
        exit;
    }else{
        echo "error";
        exit;
    }
}else{
    echo "success";
    exit;
}

?>