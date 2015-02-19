<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/imagenes.class.php");
include_once("../../../clases/imagenes_sedes.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objImagenes = new Imagenes;
$objImagenesSedes = new ImagenesSedes;

$id_sede = $_GET['code'];

$objImagenesSedes->get_imagenes_por_sede($id_sede);
$array_imagenes = $objImagenesSedes->array_campos;

$objImagenes->get_total_imagenes_activos($_SESSION['cliente']);
$total_imagenes = $objImagenes->result;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual MOBILE IPV" />
    <meta name="description" content="Gestion para el punto de venta" />
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
    
    <?php echo $objGui->icon; ?>
    
    <!--<link href="../../../css/dataTables/demo_table_jui.css" rel="stylesheet" />-->

    <!-- Load JavaScript Libraries -->
    <script src="../../../js/jquery/jquery.js"></script>
    <script src="../../../js/jquery/jquery.min.js"></script>
    <script src="../../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../../js/jquery/jquery.dataTables.js"></script>
    <script src="../../../js/prettify/prettify.js"></script>
    <script src="../../../js/holder/holder.js"></script>
    
    <script src="../../../js/load-metro.js"></script>

        
    <script type="text/javascript">
        var total_seleccionados = <?php echo count($array_imagenes); ?>;
        var total_areas = <?php echo $total_imagenes; ?>;
        
        function seleccionar_video(video_id){            
            $("#video_"+video_id).toggleClass('selected');
            
            if($("#video_"+video_id).hasClass('selected')){
                var html = "";
                html += '<input class="video_hidden" type="hidden" name="videos[]" value="'+video_id+'" />';
                $("#video_"+video_id).append(html);
                total_seleccionados++;
            }else{
                $("#video_"+video_id).find('.video_hidden').remove();
                total_seleccionados--;
            }
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function selecciona_todo(check){
            var seleccionados = 0;
            $.each($("#todos_videos .tile"), function(i){
                if($(check).is(':checked')){
                    if(!$(this).hasClass('selected')){
                        $(this).addClass('selected');
                        var html = "";
                        var id_video = $(this).find('#id_video').val();
                        html += '<input class="video_hidden" type="hidden" name="videos[]" value="'+id_video+'" />';
                        $(this).append(html);
                    }
                    seleccionados = total_areas;
                }else{
                    if($(this).hasClass('selected')){
                        $(this).removeClass('selected');
                        $(this).find('.video_hidden').remove();
                    }
                    seleccionados = 0;
                }
            });
            total_seleccionados = seleccionados;
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function inverso_videos(check){
            var seleccionados = 0;
            $.each($("#todos_videos .tile"), function(i){
                $(this).toggleClass('selected');                
                if($(this).hasClass('selected')){
                    var html = "";
                    var id_area = $(this).find('#id_video').val();
                    html += '<input class="video_hidden" type="hidden" name="videos[]" value="'+id_area+'" />';
                    $(this).append(html);
                    seleccionados ++;
                }else{
                    $(this).find('.video_hidden').remove();
                }
            });
            total_seleccionados = seleccionados;
            $("#cantidad_seleccion").html(total_seleccionados);
        }       
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
        }
        
        function guardar_videos_sedes(){
            var form_videos = $("#form_videos").serialize();
            
            $.ajax({
                type: "POST",
                url: 'agregar_imagenes_por_sede.php',
                data: form_videos,
                success: function(data) {
                    if(data == 'success'){
                        $.Notify({
                            content: "Datos almacenados correctamente.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        window.location = 'index.php';
                    }else{
                        $.Notify({
                            content: "Ha ocurrido un error por favor intente mas tarde.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                    }
                }
            });
        }
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Asociar<small class="on-right">Imagenes a sedes</small>
                </h1>
                
                <div class="span10">
                <span style="font-size: 20px;">Imagenes seleccionadas:&nbsp;<span id="cantidad_seleccion"><?php echo count($array_imagenes); ?></span> de <?php echo $total_imagenes; ?></span>
                    <div class="input-control checkbox" style="float: right; margin-left: 10px;">
                        <label>
                            <input type="checkbox" onclick="selecciona_todo(this);" />
                            <span class="check"></span>
                            Todos
                        </label>
                    </div>
                    <div class="input-control place-rigth checkbox" style="float: right;">
                        <label>
                            <input type="checkbox" onclick="inverso_videos(this)" />
                            <span class="check"></span>
                            Inverso
                        </label>
                    </div>
                </div>
                <form id="form_videos" action="javascript: guardar_videos_sedes();">
                    <input type="hidden" name="sede" value="<?php echo $id_sede; ?>" />
                    <div id="todos_videos" class="tile-group six" style="border: 1px; border-color: #999999; border-style: solid; padding-top: 0px !important; overflow: auto; height: 500px;">
                        <?php
                            $objImagenes->get_imagenes_activos($_SESSION['cliente']);
                            if($objImagenes->has_value){
                                foreach($objImagenes->array_campos as $row){ ?>
                                    <div class="tile double bg-white live <?php echo (in_array($row['IMA_ID'],$array_imagenes))?'selected':'' ?>" id="video_<?php echo $row['IMA_ID']; ?>" onclick="seleccionar_video('<?php echo $row['IMA_ID']; ?>')" style="margin: 5px;">
                                        <div class="tile-content image">
                                            <img src="<?php echo $row['IMA_URL'] ?>" />                                            
                                        </div>
                                        <?php if(in_array($row['IMA_ID'],$array_imagenes)){ ?>
                                            <input class="video_hidden" type="hidden" name="videos[]" value="<?php echo $row['IMA_ID']; ?>" />
                                        <?php } ?>
                                        <input type="hidden" id="id_video" value="<?php echo $row['IMA_ID']; ?>" />
                                    </div>
                                <?php
                                }
                            }
                        ?>
                    </div>
                    <br />
                    <div class="span10">
                        <button style=" margin: 15px;" class="button primary large place-right">Guardar</button>
                    </div>
                </form>         
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>