<?php
ini_set("display_errors", 1);

include_once("../../../clases/codigos_terminacion.class.php");

$objCodigos_terminacion = new Codigos_terminacion;

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$cliente = $_POST['cliente'];
$id_codigo_terminacion=$_POST['codigo_terminacion_id'];

if($objCodigos_terminacion->update_codigo_terminacion($id_codigo_terminacion, $nombre, $descripcion, $cliente)){
    echo "success"; 
}else{
    echo "error";
}
?>