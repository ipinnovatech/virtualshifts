<?php
ini_set("display_errors",1);

include_once("../../../clases/videos_sedes.class.php");

$sede = $_POST['sede'];
$video_actual = $_POST['video_actual'];

$objVideosSedes = new VideosSedes;

$objVideosSedes->get_videos_por_sede_para_visor($sede, $video_actual);
if($objVideosSedes->has_value){
    if(count($objVideosSedes->array_campos) > 0){
        $videos = $objVideosSedes->array_campos;
        
        $videos = array_values($videos);
        
        $rand = rand(0,count($videos)-1);    
        $url_video = $videos[$rand]['VID_URL'];
        
        $array_respuesta['url_video'] = $url_video;
        $array_respuesta['rand'] = $videos[$rand]['VID_ID'];
    }
}
print_r(json_encode($array_respuesta));
?>