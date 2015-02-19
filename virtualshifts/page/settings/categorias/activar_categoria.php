<?php
ini_set("display_errors",1);

include_once("../../../clases/categorias.class.php");

$objCategorias = new Categorias;

$id_categoria = $_POST['id_categoria'];
//echo $_POST['accion'];
//$accion = ($_POST['accion'])?0:1;
//echo $accion;
if($objCategorias->activar_categoria($id_categoria, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>