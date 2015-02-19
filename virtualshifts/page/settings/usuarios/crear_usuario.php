<?php
ini_set("display_errors", 1);

include_once("../../../clases/usuarios.class.php");
$objUsuario = new Users;

$nombres = $_POST['nombre'];
$apellidos = $_POST['apellido'];
$nick = $_POST['nick'];
$password = $_POST['password'];
$tipo_usuario = $_POST['tipo_usuario'];
$cedula = $_POST['cedula'];
$cliente = $_POST['cliente'];
$mail = $_POST['mail'];
$celular = $_POST['celular'];
$ventanilla = (isset($_POST['ventanillas']))?$_POST['ventanillas']:0;
$activo = (isset($_POST['activo']) && $_POST['activo'] == 'on')?1:0;
$crea_turno = (isset($_POST['crea_turno']) && $_POST['crea_turno'] == 'on')?1:0;
$gestiona_turno = (isset($_POST['gestiona_turno']) && $_POST['gestiona_turno'] == 'on')?1:0;
$administra_sede = (isset($_POST['administra_sede']) && $_POST['administra_sede'] == 'on')?1:0;

$array_apellidos = explode(' ',$apellidos);

//$password = substr($cedula, 0,4);
//$username = strtolower(substr($nombres,0,1).$array_apellidos[0]);
if($objUsuario->validar_user($nick)){
    $array_result['status'] = "existe";
}else{
    if($objUsuario->crear_usuario($nombres, $apellidos, $nick, $password, $tipo_usuario, $cedula, $mail, $celular, $activo, $crea_turno, $gestiona_turno, $administra_sede, $cliente, $ventanilla)){
        $array_result['status'] = "success";
    }else{
        $array_result['status'] = "error";
    }
}
print_r(json_encode($array_result));
?>