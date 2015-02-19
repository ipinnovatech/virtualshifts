<?php
ini_set("display_errors",1);
session_start();

include_once("../../../../clases/estado_asesores_historico.class.php");

$objEstadoAsesoresHistorico = new EstadoAsesoresHistorico;

$aux = $_POST['aux'];

if($objEstadoAsesoresHistorico->terminar_tiempo_auxiliary(date("Y-m-d"),"auxiliary",$aux,$_SESSION['u_id'],date("H:i:s"))){
    echo "success";
}else{
    echo "error";
}

?>