<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/sedes.class.php");

$objSedes = new Sedes;

$sede = $_POST['sede'];
$logos = isset($_POST['logos'])?$_POST['logos']:array();


if($objSedes->actualizar_logo_en_sede($sede,$logos[0])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}

?>