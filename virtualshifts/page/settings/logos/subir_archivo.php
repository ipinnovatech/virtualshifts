<?php
ini_set("display_errors",1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

session_start();

include_once("../../../clases/logos.class.php");

$app_url = "http://184.168.29.222/virtualshifts/";

$objLogos = new Logos;

$descrip = $_POST['descripcion'];
$name = $_POST['nombre'];

if($_FILES['logo']['error'] == 0){
    $nombre_archivo = $_FILES['logo']['name'];
    
    if(move_uploaded_file($_FILES['logo']['tmp_name'],'../../../images/logos/'.$nombre_archivo)){
        if($objLogos->crear_logo($name, $descrip, $_SESSION['cliente'], $app_url."images/logos/".$nombre_archivo)){
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