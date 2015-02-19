<?php
ini_set("display_errors",1);

include_once("../../../clases/usuarios.class.php");

$objUsuario = new Users;

$id_user = $_POST['id_user'];
$accion = ($_POST['accion'])?1:0;

if($objUsuario->activar_crea_turno($id_user, $_POST['accion'])){
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>