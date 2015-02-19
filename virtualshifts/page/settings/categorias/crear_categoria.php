<?php
ini_set("display_errors", 1);

session_start();

include_once("../../../clases/categorias.class.php");

$objCategorias = new Categorias;

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

$objCategorias->get_cat_nombre($nombre);

if($objCategorias->has_value){
    echo "existe";
}else{
    if($objCategorias->crear_categoria($nombre,$descripcion,$_SESSION['cliente'])){
       echo "success"; 
    }else{
        echo "error";
    }
}
?>