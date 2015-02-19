<?php
ini_set("display_errors",1);

include_once("../../../clases/sedes.class.php");

$objSedes = new Sedes;

$id_sede = $_POST['id_sede'];

if($objSedes->activar_sede($id_sede, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}

?>