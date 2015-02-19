<?php
ini_set("display_errors",1);
include_once("../../gestionseguridad/security.php");
include_once("../../clases/gui.class.php");
include_once("../../clases/sedes.class.php");
include_once("../../clases/videos_sedes.class.php");
include_once("../../clases/imagenes_sedes.class.php");

if($_SESSION['id_user_type'] != 10 && $_SESSION['id_user_type'] != 11){
    header("Location: ../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);

$id_sede = isset($_GET['code'])?$_GET['code']:0;

if($id_sede == 0){
    header("Location: ../../gestionseguridad/exit.php");
}

$objSedes = new Sedes;
$objVideosSedes = new VideosSedes;
$objImagenesSedes = new ImagenesSedes;

$objSedes->get_sede_por_id_para_visor($id_sede);

$muestra_video = $objSedes->array_sedes['S_MUESTRA_VIDEO'];
$url_video = '';
if($muestra_video == 1){
    $objVideosSedes->get_videos_por_sede_para_visor($id_sede, 0);
    if($objVideosSedes->has_value){
        $rand = rand(0,count($objVideosSedes->array_campos)-1);
        
        $url_video = $objVideosSedes->array_campos[$rand]['VID_URL'];
        $id_video = $objVideosSedes->array_campos[$rand]['VID_ID'];
        
        $total_videos = count($objVideosSedes->array_campos);
    }
}else{
    $objImagenesSedes->get_imagenes_por_sede_para_visor($id_sede, 0);
    if($objImagenesSedes->has_value){
        foreach($objImagenesSedes->array_campos as $row){
            $array_imagenes[] = $row['IMA_URL'];
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual DATE SHIFTS" />
    <meta name="description" content="Gestion para el punto de venta" />
    <meta name="author" content="IP Innovatech" />

    <link href="../../css/metro-bootstrap.css" rel="stylesheet" />
    <link href="../../css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="../../css/docs.css" rel="stylesheet" />
    <link href="../../css/iconFont.css" rel="stylesheet" />
    <link href="../../js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="../../css/portal.css" rel="stylesheet" />
    <link href="../../css/flipClockMaster/flipclock.css" rel="stylesheet" />
    
    
    <style>
        ul li,
        ol li {
          line-height: 37px !important;
        }
    </style>
    <?php echo $objGui->icon; ?>

    <!-- Load JavaScript Libraries -->
    <script src="../../js/jquery/jquery.js"></script>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../js/jquery/jquery.flippy.min.js"></script>
    <script src="../../js/jquery/jquery.infinitecarousel3.min.js"></script>
    <script src="../../js/prettify/prettify.js"></script>
    <script src="../../js/holder/holder.js"></script>
    
    <script src="../../js/flipClockMaster/libs/base.js"></script>
	<script src="../../js/flipClockMaster/flipclock.js"></script>
    <script src="../../js/flipClockMaster/faces/twelvehourclock.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="../../js/load-metro.js"></script>
    
    <script type="text/javascript">
        var asesor=0;
        var nomina=0;
        var seleccion=0;
        var mySonido;
        var myVideo = '';
        var myVideo1 = '';
        var tmp=0;
        
        
        //$(document).ready(function(){
//            clock = $('#reloj').FlipClock({
//                clockFace: 'TwelveHourClock',
//                language: 'es',
//                showSeconds: false
//            });            
//            
//            $("#fuente_video").attr('src', '<?php //echo $url_video; ?>');
//            $("#video1")[0].load();
//            
//            setInterval('busca_turnos()',5000);
//        })
        
    function initialize(){       
            clock = $('#reloj').FlipClock({
                clockFace: 'TwelveHourClock',
                language: 'es',
                showSeconds: false
            });            
            
            <?php if($muestra_video == 1){ ?>
                $("#fuente_video").attr('src', '<?php echo $url_video; ?>');
                $("#video1")[0].load();
            <?php }else{ ?>
                $('#carousel').infiniteCarousel({
                    showControls: false,
                    autoPilot: true,
                    autoHideCaptions: true,
                    displayTime : 15000
                });
            <?php } ?>
            setInterval('busca_turnos()',10000);        
    }
    
    function busca_turnos(){
        var sede = $("#sede").val();
        var nombre_sede = $("#nombre_sede").val();
        //$("#video1")[0].pause();
        var audio = document.getElementById('audio_cambio');
        
        $.ajax({               
            type: "POST",
            url:"gestionturnos/busca_turnos.php",
            dataType: 'json',
            data: {sede:sede, nombre_sede: nombre_sede},
            success: function(data) {
                var j = 1;
                if(data.length > 0){
                    $.each(data, function(i){                    
                        audio.load();
                        audio.play();
                        
                        var html = '';
                        
                        var nombre_usuario = '';
                        
                        if(data[i].datos_consumidor.CO_NOMBRE.length > 24){
                            nombre_usuario = data[i].datos_consumidor.CO_NOMBRE.substring(0,23)+"...";
                        }else{
                            nombre_usuario = data[i].datos_consumidor.CO_NOMBRE;
                        }
                        
                        var nombre_area = '';
                        
                        nombre_area = data[i].datos_area.AR_NOMBRE;
                        if(nombre_area.length > 20){
                            nombre_area = nombre_area.substr(0,19)+"...";
                        }else{
                            nombre_area = nombre_area;
                        }
                        
                        if( data[i].datos_area.AR_MOSTRAR_NOMBRE_PANTALLA == 1){
                            nombre_area = nombre_area;
                        }else{
                            nombre_area = '';
                        }
                        
                        html += '<div class="tile-content email">';
                        html += '<div class="email-image" style="float: right;"><img id="foto_asesor_'+(i+1)+'" class="rounded" src="'+data[i].datos_asesor.U_URL_FOTO+'" /></div>';
                        html += '<div>'
                        html += '<h3 id="area'+(i+1)+'" class="fg-red">'+nombre_area+'</h3>';
                        html += '<h2 id="turno'+(i+1)+'" class="fg-emerald"><b>Turno '+data[i].datos_area.AR_ALIAS+data[i].datos_turno.ID+'</b></h2>';
                        html += '<h4 id="usuario'+(i+1)+'" class="fg-white">'+nombre_usuario+'</h4>';
                        html += '</div>';
                        html += '<div class="brand">';
                        html += '<div class="label" style="float: right;">';
                        html += '<h4 id="ventanilla'+(i+1)+'" class="fg-white">'+data[i].datos_ventanilla.VENT_NOMBRE+'</h4>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        
                        //$("#foto_asesor_"+(i+1)).attr('src',data[i].datos_asesor.U_URL_FOTO);
//                        $("#area"+(i+1)).html(nombre_area);
//                        $("#turno"+(i+1)).html('Turno '+data[i].datos_area.AR_ALIAS+data[i].datos_turno.ID);
//                        $("#usuario"+(i+1)).html(nombre_usuario);
//                        $("#ventanilla"+(i+1)).html(data[i].datos_ventanilla.VENT_NOMBRE);                        
                        
                        $("#tile"+(i+1)).flippy({
                            duration: "250",
                            direction: "TOP",
                            onFinish: function change(){
                                $("#tile"+(i+1)).html(html);
                            }
                        });
                        j++;
                    });  
                }
                
                for(k=j; k<=4; k++){
                    var html = '';
                    
                    html += '<div class="tile-content email">';
                    html += '<div class="email-image" style="float: right;"><img id="foto_asesor_'+k+'" class="rounded" src="../../images/asesor1.png" /></div>';
                    html += '<div>'
                    html += '<h3 id="area'+k+'" class="fg-red">Area</h3>';
                    html += '<h2 id="turno'+k+'" class="fg-emerald"><b>Turno </b></h2>';
                    html += '<h4 id="usuario'+k+'" class="fg-white">Usuario</h4>';
                    html += '</div>';
                    html += '<div class="brand">';
                    html += '<div class="label" style="float: right;">';
                    html += '<h4 id="ventanilla'+k+'" class="fg-white"></h4>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    
                    $("#tile"+k).html(html);
                    
                    //$("#foto_asesor_"+j).attr('src','../../images/asesor1.png');
//                    $("#area"+j).html('Area');
//                    $("#turno"+j).html('Turno ');
//                    $("#usuario"+j).html('Usuario');
//                    $("#ventanilla"+j).html('');
                }            
            }
        });
        
    }
        
    function termino_video(){
        var video_actual = $("#video_actual").val();
        var sede = $("#sede").val();
        var total_videos = $("#total_videos").val();
        
        if(total_videos == 1){
            var video = document.getElementById("video1");
            video.currentTime = 0;
            video.play();
        }else{        
            $.ajax({               
                type: "POST",
                data: {video_actual: video_actual, sede: sede},
                dataType: 'json',
                url:"gestionvideos/cambia_video.php",
                success: function(data) {                
                    $("#fuente_video").attr('src', data.url_video);                
                    $("#video1")[0].load();
                    $("#video_actual").val(data.rand);                                   
                }
            });
        }
    }       
</script>
    
<title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="background-color: white;" onload="initialize()">
    <div class="grid">    
        <div class="row">
            <div class="tile-group three">
                <div id="tile1" class="tile triple bg-blue flipbox">
                    <div class="tile-content email">
                        <div class="email-image" style="float: right;"><img id="foto_asesor_1" class="rounded" src="../../images/asesor1.png" /></div>
                        <div>
                            <h3 id="area1" class="fg-red">Area</h3>
                            <h2 id="turno1" class="fg-emerald"><b>Turno</b></h2>
                            <h4 id="usuario1" class="fg-white">Usuario</h4>
                        </div>
                        <div class="brand">
                            <div class="label" style="float: right;">
                                <h4 id="ventanilla1" class="fg-white"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tile2" class="tile triple bg-blue flipbox">
                    <div class="tile-content email">
                        <div class="email-image" style="float: right;"><img id="foto_asesor_2" class="rounded" src="../../images/asesor1.png" /></div>
                        <div>
                            <h3 id="area2" class="fg-red">Area</h3>
                            <h2 id="turno2" class="fg-emerald"><b>Turno</b></h2>
                            <h4 id="usuario2" class="fg-white">Usuario</h4>
                        </div>
                        <div class="brand">
                            <div class="label" style="float: right;">
                                <h4 id="ventanilla2" class="fg-white"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tile3" class="tile triple bg-blue flipbox">
                    <div class="tile-content email">
                        <div class="email-image" style="float: right;"><img id="foto_asesor_3" class="rounded" src="../../images/asesor1.png" /></div>
                        <div>
                            <h3 id="area3" class="fg-red">Area</h3>
                            <h2 id="turno3" class="fg-emerald"><b>Turno</b></h2>
                            <h4 id="usuario3" class="fg-white">Usuario</h4>
                        </div>
                        <div class="brand">
                            <div class="label" style="float: right;">
                                <h4 id="ventanilla3" class="fg-white"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tile4" class="tile triple bg-blue flipbox">
                    <div class="tile-content email">
                        <div class="email-image" style="float: right;"><img id="foto_asesor_4" class="rounded" src="../../images/asesor1.png" /></div>
                        <div>
                            <h3 id="area4" class="fg-red">Area</h3>
                            <h2 id="turno4" class="fg-emerald"><b>Turno</b></h2>
                            <h4 id="usuario4" class="fg-white">Usuario</h4>
                        </div>
                        <div class="brand">
                            <div class="label" style="float: right;">
                                <h4 id="ventanilla4" class="fg-white"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="video_actual" id="video_actual" value="<?php echo $id_video; ?>" />
            <input type="hidden" id="total_videos" value="<?php echo $total_videos; ?>" />
            <input type="hidden" name="sede" id="sede" value="<?php echo $id_sede; ?>" />
            <input type="hidden" name="nombre_sede" id="nombre_sede" value="<?php echo $objSedes->array_sedes['S_NOMBRE']; ?>" />
            <div class="span8">
                <div style="margin-top: 36px;">                   
                    <img src="<?php echo $objSedes->array_sedes['L_URL']; ?>" style="float:left; width: 599px; height: 168px;" />                    
                </div>
                <div>
                    <?php if($muestra_video == 1){ ?>
                        <video id="video1" height="349px" autoplay="autoplay" <?php echo ($total_videos <= 1)?'onended="termino_video();"':'onended="termino_video();"'; //echo ($total_videos <= 1)?'loop="loop"':'onended="termino_video();"'; ?>  width="620px">
                            <source id="fuente_video" src="<?php echo $url_video; ?>" type="video/mp4" />
                        </video>
                    <?php }else{ ?>
                        <ul id="carousel">
                            <?php foreach($array_imagenes as $imagen){ ?>
                                <li><img height="349px" width="620px" src="<?php echo $imagen; ?>" /></li>
                            <?php    
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </div>
                <div style="float: right; padding-left: 166px;" id="reloj"></div>  
                <audio id="audio_cambio" autoplay="autoplay">
                     <source src="http://184.168.29.222/virtualshifts/sonidos/sonido.mp3" type="audio/mpeg" />
                </audio>
            </div>
        </div>
  
    </div>
    <?php echo $objGui->get_footer(); ?>

</body></html>