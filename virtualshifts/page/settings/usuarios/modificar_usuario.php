<?php
ini_set("display_errors", 1);

include_once("../../../clases/usuarios.class.php");

$objUsuario = new Users;

$nombres = $_POST['nombre'];
$apellidos = $_POST['apellido'];
$nick = $_POST['nick'];
$cedula = $_POST['cedula'];
$mail = $_POST['mail'];
$celular = $_POST['celular'];
$id = $_POST['user_id'];
$ventanilla = isset($_POST['ventanillas'])?$_POST['ventanillas']:0;


if($objUsuario->modificar_usuario($id, $nombres, $apellidos, $nick, $cedula, $mail, $celular, $ventanilla)){

   $array_result['status'] = "success"; 
}else{
    $array_result['status'] = "error";
}

print_r(json_encode($array_result));
?>