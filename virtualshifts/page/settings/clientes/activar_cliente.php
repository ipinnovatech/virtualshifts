<?php
ini_set("display_errors",1);

include_once("../../../clases/clientes.class.php");

$objClientes = new Clientes;

$id_cliente = $_POST['id_cliente'];
//echo $_POST['accion'];
//$accion = ($_POST['accion'])?0:1;
//echo $accion;
if($objClientes->activar_clientes($id_cliente, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}

?>