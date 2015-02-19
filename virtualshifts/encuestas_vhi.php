<?php
ini_set("display_errors",1);
session_start();

include_once("clases/gui_no_user.class.php");

$fecha_inicial = isset($_POST['fecha_inicial'])?$_POST['fecha_inicial']:date("Y-m-d");
$fecha_final = isset($_POST['fecha_final'])?$_POST['fecha_final']:date("Y-m-d");

$objGui = new GUI_NU();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual MOBILE IPV" />
    <meta name="description" content="Gestion para el punto de venta" />
    <meta name="author" content="IP Innovatech" />

    <link href="css/metro-bootstrap.css" rel="stylesheet" />
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="css/docs.css" rel="stylesheet" />
    <link href="css/iconFont.css" rel="stylesheet" />
    <link href="js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="css/simpleModal/basic.css" rel="stylesheet" />
    <link href="css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="css/simpleModal/demo.css" rel="stylesheet" />
    <link href="css/portal.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>
    
    <!--<link href="../../../css/dataTables/demo_table_jui.css" rel="stylesheet" />-->

    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.js"></script>
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="js/jquery/jquery.dataTables.js"></script>
    <script src="js/prettify/prettify.js"></script>
    <script src="js/holder/holder.js"></script>
    
    <script src="js/load-metro.js"></script>
    
    <title>Virtual HUMAN INTERFACE</title>
</head>
<body class="metro" style="height: auto;">
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="../../admin/index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Reporte<small class="on-right">Virtual HUMAN INTERFACE</small>
                </h1>
                    <form id="form_reportes" method="POST" action="encuestas_vhi_excel.php">
                    <br />
                    <div class="span2 offset1" style="float: left; font-size: 12pt;  margin-top: 5px;">Fecha inicial:&nbsp;</div>
                    <div class="input-control text size2" data-role="datepicker"
                        data-format='yyyy-mm-dd'
                        data-effect='slide'
                        data-locale='en'>
                        <input type="text" name="fecha_inicial" id="fecha_inicial" value="<?php echo $fecha_inicial; ?>" />
                        <button class="btn-date" onclick="return false;"></button>
                    </div>                    
                    <br />
                     <div class="span2 offset1" style="float: left; font-size: 12pt;  margin-top: 5px;">Fecha Final:&nbsp;</div>
                    <div class="input-control text size2" data-role="datepicker"
                        data-format='yyyy-mm-dd'
                        data-effect='slide'
                        data-locale='en'>
                        <input type="text" name="fecha_final" id="fecha_final" value="<?php echo $fecha_final; ?>" />
                        <button class="btn-date" onclick="return false;"></button>
                    </div>
                    <br />
                        <button type="submit" class="button large primary offset4" >Generar reporte</button>
                    <br />
                    </form>                    
                    <br />
            </div>
        </div>
        <br />
    </div>    
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>