<?php
ini_set("display_errors", 1);

include_once("../../../clases/sedes.class.php");

$objSedes = new Sedes;

$nombre = $_POST['nombre'];
$descrip = $_POST['descrip'];
$id_sede = $_POST['id_sede'];
$cantidad = $_POST['cantidad'];

if($objSedes->actualizar_sede($id_sede, $nombre, $descrip, $cantidad)){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>