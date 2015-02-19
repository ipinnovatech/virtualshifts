<?php
ini_set("display_errors",1);

include_once("../../../clases/codigos_terminacion.class.php");

$objCodigos_terminacion = new Codigos_terminacion;

$id_codigo_terminacion = $_POST['id_codigo_terminacion'];
//echo $_POST['accion'];
//$accion = ($_POST['accion'])?0:1;
//echo $accion;
if($objCodigos_terminacion->activar_codigo_terminacion($id_codigo_terminacion, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>