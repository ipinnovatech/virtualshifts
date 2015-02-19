<?php
ini_set("display_errors",1);
session_start();
header('Content-Type: text/html; charset=iso-8859-1');
include_once("../../../clases/clientes.class.php");
include_once("../../../clases/web_service_client.class.php");

$objCliente = new Clientes;

$cedula = $_POST['cedula'];

$objCliente->get_client($_SESSION['cliente']);

$array_respuesta['datos'] = array('nombre' => '','direccion' => '','telefono' => '','correo' => '','campo1' => '','campo2' => '','campo3' => '','campo4' => '','campo5' => '');

if($objCliente->array_campos[0]['C_METODO'] != ''){
    $objWebServiceClient = new webServiceClient($objCliente->array_campos[0]['C_URL_WEBSERVICE']);
    
    $objWebServiceClient->get_info_usuario($objCliente->array_campos[0]['C_METODO'],$objCliente->array_campos[0]['C_VARIABLE'],$cedula);
    //print_r($objWebServiceClient->result);
    //print_r($objWebServiceClient->error);
    foreach($objWebServiceClient->result as $key => $row){
        $array_respuesta['datos'][$key] = utf8_encode($row);
    }
    
    //$array_respuesta['datos'] = $objWebServiceClient->result;
}else{
    $array_respuesta['datos'] = array('nombre' => '','direccion' => '','telefono' => '','correo' => '','campo1' => '','campo2' => '','campo3' => '','campo4' => '','campo5' => '');
}

print_r(json_encode($array_respuesta));



?>