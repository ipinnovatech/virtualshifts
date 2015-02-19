<?php
ini_set("display_errors",1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

session_start();

include_once("../../../clases/imagenes.class.php");

$app_url = "http://184.168.29.222/virtualshifts/";

$objImagenes = new Imagenes;

$descrip = $_POST['descrip'];

if($_FILES['imagen']['error'] == 0){
    $nombre_archivo = $_FILES['imagen']['name'];
    
    if(move_uploaded_file($_FILES['imagen']['tmp_name'],'../../../images/imagenes/'.$nombre_archivo)){
        if($objImagenes->crear_imagen($descrip, $_SESSION['cliente'], $app_url."images/imagenes/".$nombre_archivo, 1)){
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