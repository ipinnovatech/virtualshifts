<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/ventanillas.class.php");
include_once("../../../clases/areas.class.php");
include_once("../../../clases/ventanillas_areas.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objVentanillas = new Ventanillas;
$objAreas = new Areas;
$objVentanillasAreas = new VentanillasAreas;

$id_ventanilla = (isset($_GET['code']))?$_GET['code']:0;

if($id_ventanilla != 0){
    $objVentanillas->get_ventanillas_por_id($id_ventanilla);
}else{
    header('Location: index.php');
}

$objAreas->get_total_areas($_SESSION['cliente']);
$total_Areas = $objAreas->total;

$objVentanillasAreas->get_areas_por_ventanilla($id_ventanilla);
$array_areas = $objVentanillasAreas->array_areas;

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
        var total_seleccionados = <?php echo count($array_areas); ?>;
        var total_areas = <?php echo $total_Areas; ?>;
        
        function seleccionar_area(area_id){            
            $("#area_"+area_id).toggleClass('selected');
            
            if($("#area_"+area_id).hasClass('selected')){
                $("#area_"+area_id).removeClass('bg-blue');
                $("#area_"+area_id).addClass('bg-emerald');
                var html = "";
                html += '<input class="area_hidden" type="hidden" name="areas[]" value="'+area_id+'" />';
                $("#area_"+area_id).append(html);
                total_seleccionados++;
            }else{
                $("#area_"+area_id).removeClass('bg-emerald');
                $("#area_"+area_id).addClass('bg-blue');
                $("#area_"+area_id).find('.area_hidden').remove();
                total_seleccionados--;
            }
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function selecciona_todo(check){
            var seleccionados = 0;
            $.each($("#todas_areas .tile"), function(i){
                if($(check).is(':checked')){
                    if(!$(this).hasClass('selected')){
                        $(this).addClass('selected');
                        $(this).removeClass('bg-blue');
                        $(this).addClass('bg-emerald');
                        var html = "";
                        var id_area = $(this).find('#id_area').val();
                        html += '<input class="area_hidden" type="hidden" name="areas[]" value="'+id_area+'" />';
                        $(this).append(html);
                    }
                    seleccionados = total_areas;
                }else{
                    if($(this).hasClass('selected')){
                        $(this).removeClass('selected');
                        $(this).removeClass('bg-emerald');
                        $(this).addClass('bg-blue');
                        $(this).find('.area_hidden').remove();
                    }
                    seleccionados = 0;
                }
            });
            total_seleccionados = seleccionados;
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function inverso_areas(check){
            var seleccionados = 0;
            $.each($("#todas_areas .tile"), function(i){
                $(this).toggleClass('selected');                
                if($(this).hasClass('selected')){
                    $(this).removeClass('bg-blue');
                    $(this).addClass('bg-emerald');
                    var html = "";
                    var id_area = $(this).find('#id_area').val();
                    html += '<input class="area_hidden" type="hidden" name="areas[]" value="'+id_area+'" />';
                    $(this).append(html);
                    seleccionados ++;
                }else{
                    $(this).removeClass('bg-emerald');
                    $(this).addClass('bg-blue');
                    $(this).find('.area_hidden').remove();
                }
            });
            total_seleccionados = seleccionados;
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function guardar_areas_ventanilla(){
            var form_areas = $("#form_areas").serialize();
            
            $.ajax({
                type: "POST",
                url: 'agregar_areas_por_ventanilla.php',
                data: form_areas,
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
        
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
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
                    Ventanillas<small class="on-right">Asociar areas</small>
                </h1>
                <div class="span10">
                <span style="font-size: 20px;">Areas seleccionadas:&nbsp;<span id="cantidad_seleccion"><?php echo count($array_areas); ?></span> de <?php echo $total_Areas; ?></span>
                    <div class="input-control checkbox" style="float: right; margin-left: 10px;">
                        <label>
                            <input type="checkbox" onclick="selecciona_todo(this);" />
                            <span class="check"></span>
                            Todos
                        </label>
                    </div>
                    <div class="input-control place-rigth checkbox" style="float: right;">
                        <label>
                            <input type="checkbox" onclick="inverso_areas(this)" />
                            <span class="check"></span>
                            Inverso
                        </label>
                    </div>
                </div>
                <form id="form_areas" action="javascript: guardar_areas_ventanilla();">
                    <input type="hidden" name="ventanilla" value="<?php echo $id_ventanilla; ?>" />
                    <div id="todas_areas" class="tile-group seven" style="border: 1px; border-color: #999999; border-style: solid; padding-top: 0px !important; overflow: auto; height: 500px;">
                        <?php
                            $objAreas->get_areas($_SESSION['cliente']);
                            if($objAreas->has_value){
                                foreach($objAreas->array_areas as $row){ ?>
                                    <div class="tile double <?php echo (in_array("'".$row['AR_ID']."'",$array_areas))?'bg-emerald':'bg-blue' ?> live <?php echo (in_array($row['AR_ID'],$array_areas))?'selected':'' ?>" id="area_<?php echo $row['AR_ID']; ?>" onclick="seleccionar_area('<?php echo $row['AR_ID']; ?>')" style="margin: 5px;">
                                        <div class="tile-content email">
                                            <div class="email-image"><b style="font-size: 44pt;" class="icon-layers-alt fg-white"></b></div>
                                            <div class="email-data">
                                                <span class="email-data-title"><?php echo $row['AR_NOMBRE']; ?></span>
                                                <span class="email-data-text"></span>
                                                <span class="email-data-subtitle"><?php echo $row['AR_DESCRIPCION']; ?></span>                                                
                                            </div>
                                        </div>
                                        <?php if(in_array($row['AR_ID'],$array_areas)){ ?>
                                            <input class="area_hidden" type="hidden" name="areas[]" value="<?php echo $row['AR_ID']; ?>" />
                                        <?php } ?>
                                        <input type="hidden" id="id_area" value="<?php echo $row['AR_ID']; ?>" />
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
                <br />
                <br />             
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>