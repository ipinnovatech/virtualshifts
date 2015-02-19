<?php
ini_set("display_errors", 1);

session_start();
include_once("../../../clases/codigos_terminacion.class.php");

$objCodigos_terminacion = new Codigos_terminacion;

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

$objCodigos_terminacion->get_ct_nombre($nombre);

if($objCodigos_terminacion->has_value){
    echo "existe";
}else{
    if($objCodigos_terminacion->crear_codigo_terminacion($nombre,$descripcion,$_SESSION['cliente'])){
       echo "success"; 
    }else{
        echo "error";
    }
}
?>