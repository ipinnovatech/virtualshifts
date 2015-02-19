<?php
ini_set("display_errors", 1);

include_once("../../../clases/clientes.class.php");

$objClientes = new Clientes;

$razon = $_POST['razon'];
$nit = $_POST['nit'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$representante = $_POST['representante'];
$e_mail = $_POST['e_mail'];
$celular = $_POST['celular'];
$webservice = $_POST['webservice'];
$metodo = $_POST['metodo'];
$variable = $_POST['variable'];
$virtualpbax=$_POST['virtualpbax'];

$objClientes->get_client_razon($razon);
if($objClientes->has_value){
    echo "existe";
}else{
    if($objClientes->crear_cliente($razon,$nit,$telefono,$direccion,$representante,$celular,$e_mail,'1',$webservice,$metodo,$variable,$virtualpbax)){
       echo "success"; 
    }else{
        echo "error";
    }
}
?>