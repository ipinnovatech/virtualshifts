<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/categorias.class.php");
include_once("../../../clases/codigos_terminacion.class.php");
include_once("../../../clases/categorias_codigos_terminacion.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objCategorias = new Categorias;
$objCodigos_terminacion = new Codigos_terminacion;
$objCategoriasCodigos_terminacion = new CategoriasCodigos_terminacion;

$id_categoria = (isset($_GET['code']))?$_GET['code']:0;

if($id_categoria != 0){
    $objCategorias->get_categorias_por_id($id_categoria);
}else{
    header('Location: index.php');
}

$objCodigos_terminacion->get_total_codigos_terminacion($_SESSION['cliente']);
$total_Codigos_terminacion = $objCodigos_terminacion->total;

$objCategoriasCodigos_terminacion->get_codigos_terminacion_por_categoria($id_categoria);
$array_campos = $objCategoriasCodigos_terminacion->array_campos;

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
        var total_seleccionados = <?php echo count($array_campos); ?>;
        var total_codigos_terminacion = <?php echo $total_Codigos_terminacion; ?>;
        
        function seleccionar_codigo_terminacion(codigo_terminacion_id){            
            $("#codigo_terminacion_"+codigo_terminacion_id).toggleClass('selected');
            
            if($("#codigo_terminacion_"+codigo_terminacion_id).hasClass('selected')){
                $("#codigo_terminacion_"+codigo_terminacion_id).removeClass('bg-blue');
                $("#codigo_terminacion_"+codigo_terminacion_id).addClass('bg-emerald');
                var html = "";
                html += '<input class="codigo_terminacion_hidden" type="hidden" name="codigos_terminacion[]" value="'+codigo_terminacion_id+'" />';
                $("#codigo_terminacion_"+codigo_terminacion_id).append(html);
                total_seleccionados++;
            }else{
                $("#codigo_terminacion_"+codigo_terminacion_id).removeClass('bg-emerald');
                $("#codigo_terminacion_"+codigo_terminacion_id).addClass('bg-blue');
                $("#codigo_terminacion_"+codigo_terminacion_id).find('.codigo_terminacion_hidden').remove();
                total_seleccionados--;
            }
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function selecciona_todo(check){
            var seleccionados = 0;
            $.each($("#todas_codigos_terminacion .tile"), function(i){
                if($(check).is(':checked')){
                    if(!$(this).hasClass('selected')){
                        $(this).addClass('selected');
                        $(this).removeClass('bg-blue');
                        $(this).addClass('bg-emerald');
                        var html = "";
                        var id_codigo_terminacion = $(this).find('#id_codigo_terminacion').val();
                        html += '<input class="codigo_terminacion_hidden" type="hidden" name="codigos_terminacion[]" value="'+id_codigo_terminacion+'" />';
                        $(this).append(html);
                    }
                    seleccionados = total_codigos_terminacion;
                }else{
                    if($(this).hasClass('selected')){
                        $(this).removeClass('selected');
                        $(this).removeClass('bg-emerald');
                        $(this).addClass('bg-blue');
                        $(this).find('.codigo_terminacion_hidden').remove();
                    }
                    seleccionados = 0;
                }
            });
            total_seleccionados = seleccionados;
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function inverso_codigos_terminacion(check){
            var seleccionados = 0;
            $.each($("#todas_codigos_terminacion .tile"), function(i){
                $(this).toggleClass('selected');                
                if($(this).hasClass('selected')){
                    $(this).removeClass('bg-blue');
                    $(this).addClass('bg-emerald');
                    var html = "";
                    var id_codigo_terminacion = $(this).find('#id_codigo_terminacion').val();
                    html += '<input class="codigo_terminacion_hidden" type="hidden" name="codigos_terminacion[]" value="'+id_codigo_terminacion+'" />';
                    $(this).append(html);
                    seleccionados ++;
                }else{
                    $(this).removeClass('bg-emerald');
                    $(this).addClass('bg-blue');
                    $(this).find('.codigo_terminacion_hidden').remove();
                }
            });
            total_seleccionados = seleccionados;
            $("#cantidad_seleccion").html(total_seleccionados);
        }
        
        function guardar_codigos_terminacion_categoria(){
            var form_codigos_terminacion = $("#form_codigos_terminacion").serialize();
            
            $.ajax({
                type: "POST",
                url: 'agregar_codigos_terminacion_por_categoria.php',
                data: form_codigos_terminacion,
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
                    Categorias<small class="on-right">Asociar C&oacute;digos de terminaci&oacute;n</small>
                </h1>
                <div class="span10">
                <span style="font-size: 20px;">C&oacute;digos de terminaci&oacute;n seleccionados:&nbsp;<span id="cantidad_seleccion"><?php echo count($array_campos); ?></span> de <?php echo $total_Codigos_terminacion; ?></span>
                    <div class="input-control checkbox" style="float: right; margin-left: 10px;">
                        <label>
                            <input type="checkbox" onclick="selecciona_todo(this);" />
                            <span class="check"></span>
                            Todos
                        </label>
                    </div>
                    <div class="input-control place-rigth checkbox" style="float: right;">
                        <label>
                            <input type="checkbox" onclick="inverso_codigos_terminacion(this)" />
                            <span class="check"></span>
                            Inverso
                        </label>
                    </div>
                </div>
                <form id="form_codigos_terminacion" action="javascript: guardar_codigos_terminacion_categoria();">
                    <input type="hidden" name="categoria" value="<?php echo $id_categoria; ?>" />
                    <div id="todas_codigos_terminacion" class="tile-group six" style="border: 1px; border-color: #999999; border-style: solid; padding-top: 0px !important; overflow: auto; height: 500px;">
                        <?php
                            $objCodigos_terminacion->get_codigos_terminacion_activos_por_cliente($_SESSION['cliente']);
                            if($objCodigos_terminacion->has_value){
                                foreach($objCodigos_terminacion->array_campos as $row){ ?>
                                    <div class="tile double <?php echo (in_array($row['CT_ID'],$array_campos))?'bg-emerald':'bg-blue' ?> live <?php echo (in_array($row['CT_ID'],$array_campos))?'selected':'' ?>" id="codigo_terminacion_<?php echo $row['CT_ID']; ?>" onclick="seleccionar_codigo_terminacion('<?php echo $row['CT_ID']; ?>')" style="margin: 5px;">
                                        <div class="tile-content email">
                                            <div class="email-image"><b style="font-size: 44pt;" class="icon-flag-2 fg-white"></b></div>
                                            <div class="email-data">
                                                <span class="email-data-title"><?php echo $row['CT_NOMBRE']; ?></span>
                                                <span class="email-data-text"></span>
                                                <span class="email-data-subtitle"><?php echo $row['CT_DESCRIPCION']; ?></span>                                                
                                            </div>
                                        </div>
                                        <?php if(in_array($row['CT_ID'],$array_campos)){ ?>
                                            <input class="codigo_terminacion_hidden" type="hidden" name="codigos_terminacion[]" value="<?php echo $row['CT_ID']; ?>" />
                                        <?php } ?>
                                        <input type="hidden" id="id_codigo_terminacion" value="<?php echo $row['CT_ID']; ?>" />
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