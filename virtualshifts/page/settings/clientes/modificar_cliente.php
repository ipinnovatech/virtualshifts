<?php
ini_set("display_errors", 1);
session_start();
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
$id_cliente = (isset($_GET['code']))?$_GET['code']:0;;
$virtualpbax=$_POST['virtualpbax'];

if($objClientes->update_cliente($id_cliente, $razon,$nit,$direccion,$telefono,$representante,$e_mail,$celular,$webservice,$metodo,$variable,$virtualpbax)){
   echo "success"; 
}else{
    echo "error";
}
?>