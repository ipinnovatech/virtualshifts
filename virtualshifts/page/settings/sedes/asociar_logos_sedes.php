<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/logos.class.php");
include_once("../../../clases/sedes.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objLogos = new Logos;
$objSedes = new Sedes;

$id_sede = $_GET['code'];

$objSedes->get_sede_por_id($id_sede);
$logo_de_sede = $objSedes->array_sedes['S_LOGO'];

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
        
        function seleccionar_logo(logo_id){
            
            $.each($("#todos_logos .tile"), function(){
                $(this).removeClass('selected');
                console.log($(this).find(".logo_hidden").val());
                $(this).find(".logo_hidden").remove();
            });
            
            $("#logo_"+logo_id).toggleClass('selected');
            
            if($("#logo_"+logo_id).hasClass('selected')){
                var html = "";
                html += '<input class="logo_hidden" type="hidden" name="logos[]" value="'+logo_id+'" />';
                $("#logo_"+logo_id).append(html);
            }         
        }        
        
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
        }
        
        function guardar_logos_sedes(){
            var form_logos = $("#form_logos").serialize();
            
            $.ajax({
                type: "POST",
                url: 'agregar_logo_por_sede.php',
                data: form_logos,
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
                    Asociar<small class="on-right">Logos a sedes</small>
                </h1>                
                
                <form id="form_logos" action="javascript: guardar_logos_sedes();">
                    <input type="hidden" name="sede" value="<?php echo $id_sede; ?>" />
                    <div id="todos_logos" class="tile-group six" style="border: 1px; border-color: #999999; border-style: solid; padding-top: 0px !important; overflow: auto; height: 500px;">
                        <?php
                            $objLogos->get_logos_por_cliente($_SESSION['cliente']);
                            if($objLogos->has_value){
                                foreach($objLogos->array_campos as $row){ ?>
                                    <div class="tile double bg-white live <?php echo ($row['L_ID'] == $logo_de_sede)?'selected':'' ?>" id="logo_<?php echo $row['L_ID']; ?>" onclick="seleccionar_logo('<?php echo $row['L_ID']; ?>')" style="margin: 5px;">
                                        <div class="tile-content image">
                                            <img src="<?php echo $row['L_URL'] ?>" />
                                        </div>
                                        <?php if($row['L_ID'] == $logo_de_sede){ ?>
                                            <input class="logo_hidden" type="hidden" name="logos[]" value="<?php echo $row['L_ID']; ?>" />
                                        <?php } ?>
                                        <input type="hidden" id="id_logo" value="<?php echo $row['L_ID']; ?>" />
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