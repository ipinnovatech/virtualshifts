<?php
ini_set("display_errors",1);

include_once("../../../clases/auxiliaries.class.php");

$objAuxiliaries = new Auxiliaries;

$id_auxiliary = $_POST['id_auxiliary'];
//echo $_POST['accion'];
//$accion = ($_POST['accion'])?0:1;
//echo $accion;
if($objAuxiliaries->activar_auxiliary($id_auxiliary, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>