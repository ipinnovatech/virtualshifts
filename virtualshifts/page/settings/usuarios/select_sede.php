<?php
ini_set("display_errors", 1);

include_once("../../../clases/ventanillas.class.php");

$objSede = new Ventanillas;

$sede = $_POST['sede'];

$objSede->get_ventanillas_activas_por_sede($sede);

if($objSede->has_value){
    $array_result['status'] = "success";
    $array_result['datos'] = $objSede->array_ventanillas;
}else{
    $array_result['status'] = "error";
    $array_result['datos'] = array();
}
print_r(json_encode($array_result));
?>