<?php
ini_set("display_errors",1);

include_once("../../../clases/areas.class.php");

$objAreas = new Areas;

$id_area = $_POST['id_area'];

if($objAreas->activar_area($id_area, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}

?>