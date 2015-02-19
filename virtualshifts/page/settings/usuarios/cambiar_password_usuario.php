<?php
ini_set("display_errors", 1);

include_once("../../../clases/usuarios.class.php");

$objUsuario = new Users;

$password = $_POST['pass'];
$id = $_POST['id_user'];

if($objUsuario->modificar_password($id, $password)){
   echo "success"; 
}else{
    echo "error";
}
?>