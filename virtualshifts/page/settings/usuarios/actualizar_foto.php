<?php
ini_set("display_errors",1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

include_once("../../../clases/usuarios.class.php");

$app_url = "http://ipvirtualmobile.com/virtualshifts/";

$objUsuario = new Users;

$id_usuario = $_POST['id_usuario'];

if($_FILES['achivo_foto']['error'] == 0){
    $nombre_archivo = $_FILES['achivo_foto']['name'];
    
    if(move_uploaded_file($_FILES['achivo_foto']['tmp_name'],'../../../images/fotos/'.$nombre_archivo)){
        if($objUsuario->actulizar_foto($id_usuario, $app_url."images/fotos/".$nombre_archivo)){
            echo "success";
        }else{
            echo "error";
        }
    }else{
        echo "error";
    }
}else{
    echo "error";
}
?>