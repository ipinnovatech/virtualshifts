<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/imagenes_sedes.class.php");

$objImagenesSedes = new ImagenesSedes;

$sede = $_POST['sede'];
$videos = isset($_POST['videos'])?$_POST['videos']:array();

$objImagenesSedes->delete_imagenes_por_sede($sede);

if(count($videos)>0){
    if($objImagenesSedes->agregar_imagenes_por_sede($sede,$videos)){
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