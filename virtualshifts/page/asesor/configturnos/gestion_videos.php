<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/videos.class.php");

if($_SESSION['id_user_type'] != 11){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objAreas = new Videos;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual SHIFTS" />
    <meta name="description" content="Configuración de la Interface Virtual Shifts" />
    <meta name="author" content="IP Innovatech" />

    <link href="../../../css/metro-bootstrap.css" rel="stylesheet" />
    <link href="../../../css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="../../../css/docs.css" rel="stylesheet" />
    <link href="../../../css/iconFont.css" rel="stylesheet" />
    <link href="../../../js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="../../../css/simpleModal/basic.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/demo.css" rel="stylesheet" />
    <link href="../../../css/portal.css" rel="stylesheet" />
    <link href="../../../css/flipClockMaster/flipclock.css" rel="stylesheet" />
    <link href="../../../css/iconFont.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>
   
    <script src="../../../js/jquery/jquery.js"></script>
    <script src="../../../js/jquery/jquery.min.js"></script>
    <script src="../../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../../js/prettify/prettify.js"></script>
    <script src="../../../js/holder/holder.js"></script>
    
    <script src="../../../js/load-metro.js"></script>
        
    <script src="../../../js/simpleModal/jquery.simplemodal.js"></script>
    <script src="../../../js/flipClockMaster/libs/base.js"></script>
	<script src="../../../js/flipClockMaster/flipclock.js"></script>
    <script src="../../../js/flipClockMaster/faces/twelvehourclock.js"></script>

    <script src="../../../js/funciones.js"></script>
    
    <style>
        ul li,
        ol li {
          line-height: 37px !important;
        }
    </style>
        
    <script type="text/javascript">
    
        $(document).ready(function(){
            var clock = $('#reloj').FlipClock({
                clockFace: 'TwelveHourClock',
                language: 'es',
                showSeconds: false
            });
            var clock2 = $('#tiempo_cita').FlipClock({
                autoStart: false,
                language: 'es'
            });
        })
                
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
        }
        
        function validar_inputs(input){
            if( $(input).val() != "" ){
                if($(input).parent().next().is('span')){
                    $(input).parent().next().remove('span');
                    $(input).parent().removeClass("error-state");
                    $(input).parent().removeClass("warning-state");
                    $(input).parent().removeClass("info-state");
                }
            }
        }
        
        function cargar_video(){
            var cliente = $("#cliente").val();
            
            $.ajax({
                type: "POST",
                url: 'muestra_video_cliente.php',
                data: {cliente:cliente},
                dataType: 'json',
                success: function(data) {
                     $("#nombre").val(data.datos[0].C_RAZON_SOCIAL);
                     $("#perfil").html(data.html);
                     $("#id_cliente").val(cliente);
                     $("#cliente").val(cliente);
                     console.log(data.datos.C_RAZON_SOCIAL);                     
                }
            });
            
            $(".closeModal").click();
        }               
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <div style="width: 300px; height: 300px; margin-left: auto; margin-right: auto;" id="basic-modal-content" class="bg-transparent fg-white">
        <img style="display: block; margin-left: auto; margin-right: auto;" src="../../../images/loading_blanco.gif" />
	</div>
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="../index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Gesti&oacute;n <small class="on-right">de Videos</small>
                </h1>
                <input type="file" name="video"/>
                <button class="primary" style="float: right; margin: 10px;" onclick="cargar_video();">Cargar Video</button>
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    
    </body>
</html>