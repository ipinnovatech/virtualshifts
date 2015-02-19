<?php
ini_set("display_errors",1);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

session_start();

include_once("../../../clases/videos.class.php");

$app_url = "http://184.168.29.222/virtualshifts/";

$objVideos = new Videos;

$descrip = $_POST['descrip'];

if($_FILES['video']['error'] == 0){
    $nombre_archivo = $_FILES['video']['name'];
    
    if(move_uploaded_file($_FILES['video']['tmp_name'],'../../../vids/'.$nombre_archivo)){
        if($objVideos->crear_video($descrip, $_SESSION['cliente'], $app_url."vids/".$nombre_archivo, 1)){
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