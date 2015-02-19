<?php
ini_set("display_errors", 1);

include_once("../../../clases/categorias.class.php");

$objCategorias = new Categorias;

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$cliente = $_POST['cliente'];
$id_categoria=$_POST['categoria_id'];

if($objCategorias->update_categoria($id_categoria, $nombre, $descripcion, $cliente)){
    echo "success"; 
}else{
    echo "error";
}
?>