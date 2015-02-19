<?php
ini_set("display_errors", 1);

include_once("../../../clases/areas.class.php");

$objAreas = new Areas;

$nombre = $_POST['nombre'];
$descrip = $_POST['descrip'];
$id_area = $_POST['id_area'];
$alias = $_POST['alias'];

if($objAreas->actualizar_area($id_area, $nombre, $descrip, $alias)){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>
