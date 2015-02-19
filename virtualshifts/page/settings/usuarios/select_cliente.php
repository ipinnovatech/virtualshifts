<?php
ini_set("display_errors", 1);

include_once("../../../clases/sedes.class.php");

$objSede = new Sedes;

$cliente = $_POST['cliente'];

$objSede->get_sedes_activas_por_cliente($cliente);

if($objSede->has_value){
    $array_result['status'] = "success";
    $array_result['datos'] = $objSede->array_sedes;
}else{
    $array_result['status'] = "error";
    $array_result['datos'] = array();
}

print_r(json_encode($array_result));
?>