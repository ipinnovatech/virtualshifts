<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/categorias_codigos_terminacion.class.php");

$objCategoriasCodigos_terminacion = new CategoriasCodigos_terminacion;

$categoria = $_POST['categoria'];
$codigos_terminacion = isset($_POST['codigos_terminacion'])?$_POST['codigos_terminacion']:array();

$objCategoriasCodigos_terminacion->delete_codigos_terminacion_por_categoria($categoria);

if(count($codigos_terminacion)>0){
    if($objCategoriasCodigos_terminacion->agregar_codigos_terminacion_por_categoria($categoria,$codigos_terminacion)){
        echo "success";
        exit;
    }else{
        echo "error";
        exit;
    }
}else{
    echo "success";
    exit;
}

?>